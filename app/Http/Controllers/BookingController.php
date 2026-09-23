<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;


class BookingController extends Controller
{
    /**
     * Menyimpan pengajuan booking baru dari akun Klien.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'client') {
            return back()->withErrors(['booking' => 'Hanya akun klien yang dapat mengajukan reservasi.']);
        }

        $validated = $request->validate([
            'mua_id' => ['required', 'exists:users,id'],
            'service_id' => ['required', 'exists:services,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'location_address' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // 1. Ambil data MUA beserta jadwalnya
        $mua = User::with('schedules')->findOrFail($validated['mua_id']);

        // 2. Tentukan hari dalam angka (0 = Minggu, 1 = Senin, ... 6 = Sabtu)
        $bookingDate = Carbon::parse($validated['booking_date']);
        $dayOfWeek = $bookingDate->dayOfWeek;

        $schedule = $mua->schedules->where('day_of_week', $dayOfWeek)->first();

        // Jika MUA belum setting jadwal sama sekali, default buka 08:00 - 17:00 (kecuali Minggu)
        $isActive = $schedule ? $schedule->is_active : ($dayOfWeek !== 0);
        $startTime = $schedule ? Carbon::parse($schedule->start_time)->format('H:i') : '08:00';
        $endTime = $schedule ? Carbon::parse($schedule->end_time)->format('H:i') : '17:00';

        // Validasi: Apakah hari tersebut MUA beroperasi?
        if (!$isActive) {
            return back()->withInput()->withErrors([
                'booking_date' => 'MUA tidak beroperasi / libur pada hari ' . $bookingDate->translatedFormat('l') . '.'
            ]);
        }

        // Validasi: Apakah jam booking berada dalam rentang jam operasional?
        $requestedTime = Carbon::parse($validated['booking_time'])->format('H:i');
        if ($requestedTime < $startTime || $requestedTime > $endTime) {
            return back()->withInput()->withErrors([
                'booking_time' => "Jam mulai booking harus di antara jam operasional MUA ({$startTime} - {$endTime} WIB)."
            ]);
        }

        $service = Service::findOrFail($validated['service_id']);

        // Waktu mulai dan perkiraan selesai pengerjaan rias
        $newStart = Carbon::parse("{$validated['booking_date']} {$validated['booking_time']}");
        $newEnd = (clone $newStart)->addMinutes($service->duration_minutes);

        // ==============================================================
        // VALIDASI BARU: CEK APAKAH RIASAN SELESAI MELEWATI JAM TUTUP MUA
        // ==============================================================
        $closingTime = Carbon::parse("{$validated['booking_date']} {$endTime}");
        if ($newEnd->gt($closingTime)) {
            $estimatedDone = $newEnd->format('H:i');
            return back()->withInput()->withErrors([
                'booking_time' => "Waktu pengerjaan ({$service->duration_minutes} menit) diperkirakan selesai pukul {$estimatedDone} WIB, melewati jam tutup operasional MUA ({$endTime} WIB). Silakan pilih jam mulai yang lebih awal."
            ]);
        }
        // ==============================================================

        // Validasi: Cek bentrok dengan jadwal booking yang sudah ada
        $existingBookings = Booking::with('service')
            ->where('mua_id', $validated['mua_id'])
            ->where('booking_date', $validated['booking_date'])
            ->whereIn('status', ['pending', 'waiting_payment', 'confirmed'])
            ->get();

        foreach ($existingBookings as $exist) {
            $existDuration = $exist->service ? $exist->service->duration_minutes : 120;
            $existStart = Carbon::parse("{$exist->booking_date} {$exist->booking_time}");
            $existEnd = (clone $existStart)->addMinutes($existDuration);

            // Logika Overlap: StartBaru < EndLama && EndBaru > StartLama
            if ($newStart->lt($existEnd) && $newEnd->gt($existStart)) {
                $occupiedFrom = $existStart->format('H:i');
                $occupiedTo = $existEnd->format('H:i');
                return back()->withInput()->withErrors([
                    'booking_time' => "Jadwal bentrok! MUA sudah memiliki agenda pada pukul {$occupiedFrom} - {$occupiedTo} WIB. Silakan pilih jam lain."
                ]);
            }
        }

        Booking::create([
            'client_id' => auth()->id(),
            'mua_id' => $validated['mua_id'],
            'service_id' => $service->id,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'location_address' => $validated['location_address'],
            'total_price' => $service->price,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Reservasi rias berhasil diajukan! Menunggu konfirmasi MUA.');
    }

    /**
     * Konfirmasi awal dari MUA untuk menerima reservasi
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        if ($booking->mua_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah pesanan ini.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:waiting_payment,cancelled'],
        ]);

        // Jika MUA menerima pesanan, arahkan status ke waiting_payment agar client bayar
        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'waiting_payment') {
            // Berikan batas waktu bayar (misal: 2 jam sejak MUA menyetujui)
            // Ganti addHours(2) ke addHours(24) jika ingin batas 1 hari
            $updateData['payment_deadline'] = now()->addHours(2);
        }

        $booking->update($updateData);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
    
    /**
     * Penyelesaian reservasi oleh MUA menggunakan kode 4 digit dari Klien
     */
    public function completeWithCode(Request $request, Booking $booking)
    {
        if ($booking->mua_id !== auth()->id()) {
            abort(403, 'Akses tidak sah.');
        }

        if ($booking->status !== 'confirmed') {
            return back()->withErrors(['code' => 'Pesanan belum dalam status siap diselesaikan.']);
        }

        // Cegah jika klien belum melunasi sisa pembayaran
        if ($booking->payment_status !== 'fully_paid') {
            return back()->withErrors(['code' => 'Pesanan belum lunas. Klien harus menyelesaikan sisa pelunasan di aplikasi terlebih dahulu.']);
        }

        $request->validate([
            'completion_code' => ['required', 'digits:4'],
        ]);

        if ($request->completion_code !== $booking->completion_code) {
            return back()->withErrors(['completion_code' => 'Kode verifikasi salah. Minta 4 digit kode yang valid dari klien Anda.']);
        }

        $booking->update([
            'status' => 'completed',
            'payment_status' => 'released_to_mua',
        ]);

        return back()->with('success', 'Pekerjaan selesai terverifikasi! Dana telah diteruskan ke akun MUA Anda.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $user = Auth::user();

        // 1. Validasi hak akses: hanya Klien pemesan atau MUA terkait yang boleh membatalkan
        if ($booking->client_id !== $user->id && $booking->mua_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk membatalkan pesanan ini.');
        }

        // 2. Validasi status (Fokus Tahap 1: belum ada uang masuk)
        // Hanya bisa batal jika status masih pending/waiting_payment DAN payment_status unpaid
        $canCancelStage1 = in_array($booking->status, ['pending', 'waiting_payment']) 
            && $booking->payment_status === 'unpaid';

        if (!$canCancelStage1) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan melalui jalur sederhana karena status sudah berjalan atau pembayaran sedang diproses.');
        }

        // 3. Validasi input alasan
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        // 4. Update data booking
        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
            'cancelled_by' => $user->id,
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function storeReview(Request $request, Booking $booking)
    {
        $user = Auth::user();

        // 1. Validasi kepemilikan booking
        if ($booking->client_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengulas pesanan ini.');
        }

        // 2. Booking harus berstatus completed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah layanan berstatus selesai.');
        }

        // 3. Pastikan belum pernah di-review
        if ($booking->review()->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        // 4. Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 5. Simpan review
        Review::create([
            'booking_id' => $booking->id,
            'client_id' => $user->id,
            'mua_id' => $booking->mua_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }


    public function show(Booking $booking)
    {
        $user = auth()->user();

        // Validasi otorisasi: hanya pemesan, MUA terkait, atau admin
        if ($booking->client_id !== $user->id && $booking->mua_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses ke rincian pesanan ini.');
        }

        $booking->load([
            'service',
            'client',
            'mua.muaProfile',
            'payments',
            'review'
        ]);

        return view('dashboard.booking-detail', compact('booking'));
    }
}