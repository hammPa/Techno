<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Klien - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex pb-20 md:pb-0 font-sans">

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-60 bg-white border-r border-rose-100 p-5 space-y-6 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-slate-900">
            <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center text-sm shadow-sm">✨</span>
            <span>Glow<span class="text-rose-600">MUA</span></span>
        </a>

        <div class="px-3 py-2 bg-slate-100 rounded-xl">
            <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider block">Mode Klien</span>
            <span class="text-xs font-semibold text-slate-800 truncate block">{{ $user->name }}</span>
        </div>

        <nav class="flex-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs">
                <span>🛍</span> Marketplace & Reservasi
            </a>
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>🏠</span> Halaman Utama
            </a>
        </nav>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-500 hover:text-rose-600 text-xs font-medium rounded-xl hover:bg-rose-50/50 transition">
                🚪 Keluar
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 max-w-5xl mx-auto p-4 sm:p-6 lg:p-8 w-full">
        <!-- Topbar -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Halo, {{ $user->name }} 👋</h1>
                <p class="text-xs text-slate-500">Pantau reservasi riasan dan cari MUA favoritmu</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase shadow-sm">
                {{ substr($user->name, 0, 2) }}
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-xs">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Card Reservasi Saya -->
        <div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Jadwal Reservasi Rias Saya</h2>
                    <p class="text-xs text-slate-400">Daftar agenda riasan yang telah Anda ajukan</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full">
                    {{ $myBookings->count() }} Pesanan
                </span>
            </div>

            <div class="space-y-3">
                @forelse($myBookings as $b)
                    <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-sm text-slate-800">{{ $b->service->title }}</h3>
                                @if($b->status === 'pending')
                                    <span class="text-[10px] px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full font-bold">Menunggu Konfirmasi</span>
                                @elseif($b->status === 'confirmed')
                                    <span class="text-[10px] px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-bold">Disetujui / Terjadwal</span>
                                @elseif($b->status === 'completed')
                                    <span class="text-[10px] px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full font-bold">Selesai</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-red-100 text-red-800 rounded-full font-bold">Dibatalkan</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mt-1">MUA: <strong class="text-slate-700">{{ $b->mua->muaProfile->studio_name ?? $b->mua->name }}</strong></p>
                            <p class="text-xs text-slate-600 mt-0.5">📅 {{ date('d M Y', strtotime($b->booking_date)) }} • Pukul {{ date('H:i', strtotime($b->booking_time)) }} WIB</p>
                            <p class="text-[11px] text-slate-400 mt-1">📍 {{ $b->location_address }}</p>
                            @if($b->notes)
                                <p class="text-[11px] text-slate-400 italic mt-0.5">Catatan: "{{ $b->notes }}"</p>
                            @endif
                        </div>

                        <div class="text-left sm:text-right border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-200">
                            <span class="text-xs text-slate-400 block">Total Biaya</span>
                            <span class="text-sm sm:text-base font-extrabold text-rose-600">
                                Rp {{ number_format($b->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs">
                        Belum ada reservasi aktif. Pilih MUA di bawah untuk mulai memesan jadwal rias.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Bagian Katalog Marketplace MUA -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-bold text-base text-slate-900">Katalog Pilihan Makeup Artist</h2>
                <p class="text-xs text-slate-400">Pilih MUA dan atur jadwal janji rias langsung</p>
            </div>
            <span class="text-xs font-semibold text-rose-600">{{ $muaList->count() }} Terdaftar</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($muaList as $mua)
                <div class="bg-white rounded-3xl border border-rose-100 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-rose-50 relative overflow-hidden flex items-center justify-center">
                            @if($mua->portfolios->isNotEmpty() && $mua->portfolios->first()->image_url)
                                <img src="{{ $mua->portfolios->first()->image_url }}" alt="{{ $mua->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">🪞</span>
                            @endif
                            <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-700">
                                📍 {{ $mua->muaProfile->city ?? 'Indonesia' }}
                            </span>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-base text-slate-900 truncate">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h3>
                                <span class="text-xs font-bold text-amber-500">★ 5.0</span>
                            </div>
                            <p class="text-xs text-slate-400">Artisan: {{ $mua->name }}</p>
                            <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                {{ $mua->muaProfile->bio ?? 'Tersedia layanan makeup wisuda, bridal, photoshoot, dan pesta.' }}
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @forelse($mua->services->take(2) as $s)
                                    <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-medium">
                                        {{ $s->title }}
                                    </span>
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">Belum ada paket</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Tarif Mulai</span>
                                <span class="text-xs sm:text-sm font-extrabold text-rose-600">
                                    @if($mua->services->isNotEmpty())
                                        Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                                    @else
                                        Hubungi MUA
                                    @endif
                                </span>
                            </div>
                            <a href="{{ route('mua.detail', $mua->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                                Portofolio & Booking →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-rose-100">
                    <p class="text-xs text-slate-400">Belum ada akun MUA terdaftar.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-6 py-2 flex items-center justify-between z-50">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-rose-600">
            <span class="text-base">🛍</span>
            <span class="text-[10px] font-semibold mt-0.5">Marketplace</span>
        </a>
        <a href="{{ route('home') }}" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">🏠</span>
            <span class="text-[10px] font-medium mt-0.5">Beranda</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
                <span class="text-base">🚪</span>
                <span class="text-[10px] font-medium mt-0.5">Keluar</span>
            </button>
        </form>
    </nav>
</body>
</html>