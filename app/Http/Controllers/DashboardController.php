<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\MuaProfile;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. JIKA YANG LOGIN ADMIN
        if ($user->role === 'admin') {
            $payments = Payment::with(['user', 'booking.mua', 'booking.service'])
                ->latest()
                ->get();

            // Ambil semua MUA beserta profil dan jumlah layanannya
            $muaUsers = User::where('role', 'mua')
                ->with(['muaProfile', 'services'])
                ->withCount('muaBookings')
                ->latest()
                ->get();

            // Ambil semua Klien beserta total pesanannya
            $clientUsers = User::where('role', 'client')
                ->withCount('clientBookings')
                ->latest()
                ->get();

            return view('dashboard.admin', compact('user', 'payments', 'muaUsers', 'clientUsers'));
        }

        // 2. JIKA YANG LOGIN MUA
        if ($user->role === 'mua') {
            $profile = MuaProfile::firstOrCreate(
                ['user_id' => $user->id],
                ['studio_name' => $user->name . ' Artistry', 'city' => 'Padang']
            );
            $services = Service::where('user_id', $user->id)->latest()->get();
            $portfolios = Portfolio::where('user_id', $user->id)->latest()->get();
            
            // Ambil daftar booking masuk ke MUA
            $bookings = Booking::where('mua_id', $user->id)
                ->with(['client', 'service'])
                ->latest()
                ->get();

            return view('dashboard.mua', compact('user', 'profile', 'services', 'portfolios', 'bookings'));
        }

        // 3. JIKA YANG LOGIN KLIEN
        $muaList = User::where('role', 'mua')
            ->whereNotNull('email_verified_at')
            ->with(['muaProfile', 'services', 'portfolios'])
            ->latest()
            ->get();

        // Ambil riwayat pesanan milik Klien
        $myBookings = Booking::where('client_id', $user->id)
            ->with(['mua.muaProfile', 'service'])
            ->latest()
            ->get();

        return view('dashboard.client', compact('user', 'muaList', 'myBookings'));
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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'], // Maks 3MB
        ]);

        // Simpan file ke folder storage/app/public/portfolios
        $path = $request->file('image')->store('portfolios', 'public');

        auth()->user()->portfolios()->create([
            'title' => $validated['title'],
            'image_url' => $path, // Menyimpan relative path file di storage
        ]);

        return back()->with('success', 'Foto portofolio rias berhasil ditambahkan!');
    }

    // Action Hapus Portofolio
    public function destroyPortfolio(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Hapus file fisik dari storage jika file ada
        if ($portfolio->image_url && Storage::disk('public')->exists($portfolio->image_url)) {
            Storage::disk('public')->delete($portfolio->image_url);
        }

        $portfolio->delete();
        return back()->with('success', 'Portofolio berhasil dihapus.');
    }
}