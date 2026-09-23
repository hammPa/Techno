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

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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

            $payouts = \App\Models\Payout::with('user')
                ->latest()->get();

            return view('dashboard.admin', compact('user', 'payments', 'muaUsers', 'clientUsers', 'payouts'));
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

            $myPayouts = $user->payouts()->latest()->get();

            // Ambil jadwal kerja MUA yang tersimpan
            $schedules = $user->schedules()->get()->keyBy('day_of_week');

            // Pemetaan nama hari
            $days = [
                1 => 'Senin',
                2 => 'Selasa',
                3 => 'Rabu',
                4 => 'Kamis',
                5 => 'Jumat',
                6 => 'Sabtu',
                0 => 'Minggu',
            ];

            return view('dashboard.mua', compact('user', 'profile', 'services', 'portfolios', 'bookings', 'myPayouts', 'schedules', 'days'));
        }

        // 3. JIKA YANG LOGIN KLIEN
        $muaList = User::where('role', 'mua')
            ->whereNotNull('email_verified_at')
            ->whereHas('muaProfile', function ($query) {
                $query->where('verification_status', 'verified');
            })
            ->with(['muaProfile', 'services', 'portfolios'])
            ->withCount('muaReviews')
            ->withAvg('muaReviews', 'rating')
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

        $mua->load(['muaProfile', 'services', 'portfolios', 'muaReviews.client', 'schedules']);

        $totalReviews = $mua->muaReviews->count();
        $averageRating = $totalReviews > 0 ? round($mua->muaReviews->avg('rating'), 1) : 0;

        // Siapkan array hari di controller
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            0 => 'Minggu',
        ];

        return view('dashboard.mua-detail', compact('mua', 'totalReviews', 'averageRating', 'dayNames'));
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

        // Simpan file ke folder storage/app/public/portfolios, karena ga ada arg public dia up ke default, karna skrg pakai supabase dia kesana
        $path = $request->file('image')->store('portfolios');

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
        if ($portfolio->image_url && Storage::exists($portfolio->image_url)) {
            Storage::delete($portfolio->image_url);
        }

        $portfolio->delete();
        return back()->with('success', 'Portofolio berhasil dihapus.');
    }


    // Menampilkan halaman form edit profil
    public function editProfile()
    {
        return view('dashboard.profile', [
            'user' => auth()->user()
        ]);
    }

    // Memproses update data profil & kredensial
    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Reset verifikasi email jika alamat email diganti
        if ($validated['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        // Hash password jika kolom diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil dan kredensial akun berhasil diperbarui!');
    }



    /**
     * MUA mengunggah foto KTP / identitas
     */
    public function uploadIdCard(Request $request)
    {
        $request->validate([
            'id_card' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        $profile = auth()->user()->muaProfile;

        // Hapus file lama jika sebelumnya sudah ada berkas di storage
        if ($profile->id_card_url && Storage::exists($profile->id_card_url)) {
            Storage::delete($profile->id_card_url);
        }

        // Mengikuti default disk (Supabase) seperti storePortfolio
        $path = $request->file('id_card')->store('id_cards');

        $profile->update([
            'id_card_url' => $path,
            'verification_status' => 'pending',
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Foto identitas berhasil dikirim dan sedang menunggu verifikasi admin.');
    }

    /**
     * Admin menyetujui verifikasi MUA
     */
    public function verifyMua(MuaProfile $muaProfile)
    {
        $muaProfile->update([
            'verification_status' => 'verified',
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'MUA berhasil diverifikasi!');
    }

    /**
     * Admin menolak verifikasi MUA dengan alasan
     */
    public function rejectMua(Request $request, MuaProfile $muaProfile)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $muaProfile->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Verifikasi MUA ditolak.');
    }
}