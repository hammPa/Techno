<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PayoutController extends Controller
{
    // MUA mengajukan penarikan saldo
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'mua') {
            abort(403);
        }

        $availableBalance = $user->available_balance;

        if ($availableBalance < 50000) {
            return back()->withErrors(['amount' => 'Saldo aktif Anda belum mencukupi batas minimal penarikan (Rp 50.000).']);
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:50000', 'max:' . $availableBalance],
            'bank_name' => ['required', 'string', 'max:50'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder' => ['required', 'string', 'max:100'],
        ], [
            'amount.max' => 'Nominal penarikan melebihi saldo aktif Anda (Maks: Rp ' . number_format($availableBalance, 0, ',', '.') . ').',
            'amount.min' => 'Batas minimal penarikan adalah Rp 50.000.',
        ]);

        $user->payouts()->create([
            'amount' => $validated['amount'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_holder' => $validated['account_holder'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan penarikan saldo berhasil diajukan! Menunggu transfer dari admin.');
    }

    // Admin menyetujui penarikan & upload bukti transfer keluar
    public function approve(Request $request, Payout $payout)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($payout->status !== 'pending') {
            return back()->withErrors(['error' => 'Permintaan penarikan ini sudah diproses sebelumnya.']);
        }

        $request->validate([
            'proof_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
        ]);

        $path = $request->file('proof_image')->store('payout_proofs');

        $payout->update([
            'status' => 'completed',
            'proof_image' => $path,
        ]);

        return back()->with('success', 'Pencairan dana MUA berhasil dikonfirmasi!');
    }

    // Admin menolak penarikan saldo
    public function reject(Request $request, Payout $payout)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'admin_notes' => ['required', 'string', 'max:255'],
        ]);

        $payout->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Permintaan penarikan dana berhasil ditolak. Saldo dikembalikan ke akun MUA.');
    }
}