<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Menyimpan paket riasan baru milik MUA yang sedang login.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:wedding,graduation,engagement,photoshoot,other'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Simpan langsung melalui relasi services milik user yang login
        auth()->user()->services()->create($validated);

        return back()->with('success', 'Paket riasan berhasil ditambahkan!');
    }

    /**
     * Menghapus paket riasan milik MUA.
     */
    public function destroy(Service $service)
    {
        // Pastikan hanya pemilik paket (MUA yang bersangkutan) yang boleh menghapus
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus paket ini.');
        }

        $service->delete();

        return back()->with('success', 'Paket riasan berhasil dihapus.');
    }
}