<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Klien mengunggah bukti transfer
     */
    public function store(Request $request, Booking $booking)
    {
        if ($booking->client_id !== auth()->id()) {
            abort(403);
        }

        // Cek apakah masih ada pembayaran yang statusnya 'pending'
        $hasPendingPayment = $booking->payments()->where('status', 'pending')->exists();
        if ($hasPendingPayment) {
            return back()->withErrors(['payment' => 'Bukti pembayaran sedang diproses oleh admin. Mohon tunggu verifikasi.']);
        }
        
        $validated = $request->validate([
            'type' => 'required|in:dp,full',
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string|max:50',
            'sender_name' => 'required|string|max:100',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'bank_name' => $validated['bank_name'],
            'sender_name' => $validated['sender_name'],
            'proof_image' => $path,
            'status' => 'pending',
        ]);

        $booking->update([
            'payment_status' => 'waiting_verification',
        ]);

        return back()->with('success', 'Bukti transfer berhasil dikirim. Menunggu verifikasi admin!');
    }

    /**
     * Verifikasi bukti pembayaran oleh Admin
     */
    public function verify(Request $request, Payment $payment)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses terbatas untuk admin.');
        }

        $payment->update(['status' => 'verified']);
        $booking = $payment->booking;

        // Generate kode 4 digit acak saat pembayaran tervalidasi
        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $booking->update([
            'status' => 'confirmed',
            'completion_code' => $code,
            'payment_status' => $payment->type === 'dp' ? 'dp_paid' : 'fully_paid',
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi. Kode penyelesaian telah diterbitkan ke Klien.');
    }
}