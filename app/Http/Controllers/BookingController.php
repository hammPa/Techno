<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

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
}