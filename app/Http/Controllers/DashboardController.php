<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\MuaProfile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // JIKA YANG LOGIN MUA: Tampilkan manajemen profil, paket, dan portofolio
        if ($user->role === 'mua') {
            $profile = MuaProfile::firstOrCreate(
                ['user_id' => $user->id],
                ['studio_name' => $user->name . ' Artistry', 'city' => 'Padang']
            );
            $services = Service::where('user_id', $user->id)->latest()->get();
            $portfolios = Portfolio::where('user_id', $user->id)->latest()->get();

            return view('dashboard.mua', compact('user', 'profile', 'services', 'portfolios'));
        }

        // JIKA YANG LOGIN KLIEN: Tampilkan Marketplace seluruh MUA yang terdaftar
        $muaList = User::where('role', 'mua')
            ->whereNotNull('email_verified_at')
            ->with(['muaProfile', 'services', 'portfolios'])
            ->latest()
            ->get();

        return view('dashboard.client', compact('user', 'muaList'));
    }

    // Detail MUA yang diklik klien (Lihat portofolio, harga, chat WA)
    public function showMua(User $mua)
    {
        if ($mua->role !== 'mua') {
            abort(404);
        }

        $mua->load(['muaProfile', 'services', 'portfolios']);
        return view('dashboard.mua-detail', compact('mua'));
    }

    // Action Simpan/Update Profil MUA
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'studio_name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'instagram_username' => ['nullable', 'string', 'max:100'],
        ]);

        MuaProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return back()->with('success', 'Profil studio berhasil diperbarui.');
    }

    // Action Tambah Portofolio Foto
    public function storePortfolio(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image_url' => ['required', 'url'], // untuk tahap dev bisa pakai URL foto Unsplash / web
        ]);

        auth()->user()->portfolios()->create($validated);

        return back()->with('success', 'Foto portofolio rias berhasil ditambahkan!');
    }

    // Action Hapus Portofolio
    public function destroyPortfolio(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id()) {
            abort(403);
        }
        $portfolio->delete();
        return back()->with('success', 'Portofolio berhasil dihapus.');
    }
}