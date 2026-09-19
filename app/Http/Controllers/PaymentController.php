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

        if ($payment->type === 'dp') {
            // Pembayaran DP disetujui, jadwal dikonfirmasi tapi belum keluar kode 4 digit
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'dp_paid',
            ]);

            return back()->with('success', 'Pembayaran DP berhasil diverifikasi. Klien perlu melunasi sisa tagihan untuk mendapatkan kode penyelesaian.');
        }

        // Jika pembayaran tipe FULL atau PELUNASAN, generate kode 4 digit
        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $booking->update([
            'status' => 'confirmed',
            'completion_code' => $code,
            'payment_status' => 'fully_paid',
        ]);

        return back()->with('success', 'Pembayaran lunas berhasil diverifikasi. Kode 4 digit telah dirilis ke Klien.');
    }

    public function reject(Request $request, Payment $payment)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses terbatas untuk admin.');
        }

        $validated = $request->validate([
            'admin_notes' => ['required', 'string', 'max:255'],
        ]);

        // Hapus file fisik bukti transfer yang ditolak
        if ($payment->proof_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($payment->proof_image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->proof_image);
        }

        $payment->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        $booking = $payment->booking;

        // Cek apakah klien sebelumnya sudah pernah membayar DP yang valid
        $hasVerifiedDp = $booking->payments()->where('type', 'dp')->where('status', 'verified')->exists();

        if ($hasVerifiedDp) {
            $booking->update([
                'payment_status' => 'dp_paid',
                'status' => 'confirmed',
            ]);
        } else {
            $booking->update([
                'payment_status' => 'unpaid',
                'status' => 'waiting_payment',
            ]);
        }

        return back()->with('success', 'Pembayaran ditolak dan alasan berhasil dicatat.');
    }
}