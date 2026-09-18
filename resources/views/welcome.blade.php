<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlowMUA - Platform Direktori & Reservasi Makeup Artist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex flex-col font-sans">

    <!-- Header / Navbar -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-rose-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-slate-900">
                <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center text-sm shadow-sm">✨</span>
                <span>Glow<span class="text-rose-600">MUA</span></span>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm">
                        Dashboard Saya →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-rose-600 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-1">
        <section class="max-w-6xl mx-auto px-4 sm:px-6 pt-10 pb-12 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold mb-4">
                💄 Platform Direktori & Reservasi MUA
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight sm:leading-tight">
                Temukan Sentuhan Riasan Sempurna untuk Hari Bahagiamu
            </h1>
            <p class="text-xs sm:text-base text-slate-500 mt-3 max-w-xl mx-auto leading-relaxed">
                Jelajahi hasil karya makeup artist profesional untuk acara wisuda, wedding, lamaran, hingga photoshoot.
            </p>

            <!-- Search Bar Mockup -->
            <div class="mt-8 max-w-xl mx-auto bg-white p-2 sm:p-2.5 rounded-2xl shadow-lg shadow-rose-950/5 border border-rose-100 flex items-center gap-2">
                <span class="pl-2 text-slate-400">🔍</span>
                <input type="text" placeholder="Cari nama MUA, acara, atau kota domisili..." class="w-full text-xs sm:text-sm focus:outline-none bg-transparent">
                <a href="#katalog" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition shrink-0">
                    Cari
                </a>
            </div>
        </section>

        <!-- Showcase Katalog MUA -->
        <section id="katalog" class="max-w-6xl mx-auto px-4 sm:px-6 pb-20">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">Pilihan MUA Terpopuler</h2>
                    <p class="text-xs text-slate-400">Lihat portofolio rias dan estimasi paket harga</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($muaList as $mua)
                    <div class="bg-white rounded-3xl border border-rose-100 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Foto Portofolio -->
                            <div class="h-48 bg-rose-50 relative overflow-hidden flex items-center justify-center">
                                @if($mua->portfolios->isNotEmpty() && $mua->portfolios->first()->image_url)
                                    <img src="{{ $mua->portfolios->first()->image_url }}" alt="{{ $mua->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl">🪞</span>
                                @endif
                                <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-700 shadow-xs">
                                    📍 {{ $mua->muaProfile->city ?? 'Indonesia' }}
                                </span>
                            </div>

                            <!-- Detail Singkat Studio -->
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-bold text-base text-slate-900 truncate">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h3>
                                    <span class="text-xs font-bold text-amber-500">★ 5.0</span>
                                </div>
                                <p class="text-xs text-slate-400">Artisan: {{ $mua->name }}</p>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $mua->muaProfile->bio ?? 'Melayani berbagai kebutuhan riasan mulai dari acara formal, wisuda, hingga bridal glam.' }}
                                </p>

                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @forelse($mua->services->take(2) as $service)
                                        <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-medium">
                                            {{ $service->title }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-slate-400 italic">Paket konsultasi custom</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="p-5 pt-0">
                            <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">Mulai Dari</span>
                                    <span class="text-xs sm:text-sm font-extrabold text-rose-600">
                                        @if($mua->services->isNotEmpty())
                                            Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                                        @else
                                            Hubungi MUA
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('mua.detail', $mua->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition">
                                    Portofolio & Tarif →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-rose-100">
                        <span class="text-4xl block mb-2">💄</span>
                        <h3 class="font-bold text-sm text-slate-800">Katalog MUA Sedang Disiapkan</h3>
                        <p class="text-xs text-slate-400 mt-1">Daftar sekarang sebagai MUA untuk menampilkan karya terbaikmu di halaman depan ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-rose-100 py-6 text-center text-xs text-slate-400">
        <p>© 2026 GlowMUA Platform. Direktori Makeup Artist Indonesia.</p>
    </footer>
</body>
</html>