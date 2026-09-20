<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
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
            'booking_time' => ['required'],
            'location_address' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $service = Service::findOrFail($validated['service_id']);

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
        $booking->update(['status' => $validated['status']]);

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


    public function cancel(Request $request, Booking$booking)
    {
        $user = Auth::user();

        // 1. Validasi hak akses: hanya Klien pemesan atau MUA terkait yang boleh membatalkan
        if ($booking->client_id !==$user->id && $booking->mua_id !==$user->id) {
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
}