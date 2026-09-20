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
     * Tampilkan halaman formulir edit paket layanan.
     */
    public function edit(Service $service)
    {
        // Cegah MUA lain mengakses/mengedit paket yang bukan miliknya
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah paket ini.');
        }

        return view('partials.mua.edit', compact('service'));
    }

    /**
     * Simpan perubahan paket layanan ke database.
     */
    public function update(Request $request, Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah paket ini.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:wedding,graduation,engagement,photoshoot,other'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $service->update($validated);

        return redirect()->route('dashboard')->with('success', 'Paket riasan berhasil diperbarui!');
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