<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlowMUA - Platform Booking Makeup Artist</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/40 text-slate-800 antialiased min-h-screen flex flex-col font-sans">

    <!-- Top Navbar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-rose-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">✨</span>
                <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900">Glow<span class="text-rose-600">MUA</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="#kategori" class="hover:text-rose-600 transition">Kategori</a>
                <a href="#mua" class="hover:text-rose-600 transition">Cari MUA</a>
                <a href="#keunggulan" class="hover:text-rose-600 transition">Keunggulan</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('login') }}" class="px-3 py-1.5 text-xs sm:text-sm font-semibold text-slate-700 hover:text-rose-600 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-rose-600 rounded-xl hover:bg-rose-700 transition shadow-sm shadow-rose-200">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1">
        <!-- Hero Section (Mobile First) -->
        <section class="px-4 pt-8 pb-12 sm:pt-14 sm:pb-16 max-w-5xl mx-auto text-center">
            <span class="inline-block py-1 px-3.5 bg-rose-100 text-rose-700 text-xs font-semibold rounded-full mb-4">
                💄 Temukan & Booking MUA Terverifikasi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Sentuhan Magis untuk Hari <span class="text-rose-600">Istimewamu</span>
            </h1>
            <p class="mt-3 text-sm sm:text-base text-slate-500 max-w-xl mx-auto">
                Layanan Makeup Artist panggilan ke lokasi atau studio untuk Pernikahan, Wisuda, Lamaran, dan Photoshoot.
            </p>

            <!-- Search Bar Widget -->
            <div class="mt-8 bg-white p-4 sm:p-5 rounded-2xl border border-rose-100 shadow-md shadow-rose-100/50 max-w-3xl mx-auto text-left">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kota / Domisili</label>
                        <select class="w-full text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-rose-500">
                            <option>Semua Lokasi</option>
                            <option>Padang</option>
                            <option>Jakarta Selatan</option>
                            <option>Bandung</option>
                            <option>Surabaya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kebutuhan Acara</label>
                        <select class="w-full text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-rose-500">
                            <option>Wedding & Bridal</option>
                            <option>Wisuda / Graduation</option>
                            <option>Lamaran / Engagement</option>
                            <option>Photoshoot & Commercial</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition shadow-sm shadow-rose-200">
                            Cari MUA 🔍
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kategori Layanan -->
        <section id="kategori" class="max-w-5xl mx-auto px-4 py-8">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-4">Kategori Populer</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm text-center">
                    <span class="text-3xl block mb-2">👰‍♀️</span>
                    <h3 class="font-bold text-xs sm:text-sm text-slate-800">Wedding Glam</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Mulai 1.5jt</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm text-center">
                    <span class="text-3xl block mb-2">🎓</span>
                    <h3 class="font-bold text-xs sm:text-sm text-slate-800">Wisuda Natural</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Mulai 350rb</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm text-center">
                    <span class="text-3xl block mb-2">💍</span>
                    <h3 class="font-bold text-xs sm:text-sm text-slate-800">Engagement Look</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Mulai 650rb</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm text-center">
                    <span class="text-3xl block mb-2">📸</span>
                    <h3 class="font-bold text-xs sm:text-sm text-slate-800">Studio & Shoot</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Mulai 450rb</p>
                </div>
            </div>
        </section>

        <!-- Featured MUA -->
        <section id="mua" class="max-w-5xl mx-auto px-4 py-8 mb-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Rekomendasi MUA</h2>
                <a href="{{ route('login') }}" class="text-xs font-semibold text-rose-600 hover:underline">Lihat Semua →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-rose-100 overflow-hidden shadow-sm p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] px-2 py-0.5 bg-rose-100 text-rose-700 rounded-full font-semibold">Bridal</span>
                            <span class="text-xs font-bold text-amber-500">★ 4.9</span>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">Clarissa Ayu MUA</h3>
                        <p class="text-xs text-slate-400">📍 Home Service / On-Location</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-600">Rp 450.000+</span>
                        <a href="{{ route('login') }}" class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold">Pesan</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-rose-100 overflow-hidden shadow-sm p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full font-semibold">Wisuda & Party</span>
                            <span class="text-xs font-bold text-amber-500">★ 5.0</span>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">Nadia Putri Artistry</h3>
                        <p class="text-xs text-slate-400">📍 Studio & Home Service</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-600">Rp 350.000+</span>
                        <a href="{{ route('login') }}" class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold">Pesan</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-rose-100 overflow-hidden shadow-sm p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full font-semibold">Traditional</span>
                            <span class="text-xs font-bold text-amber-500">★ 4.9</span>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">Siti Rahma MUA</h3>
                        <p class="text-xs text-slate-400">📍 Sedia Wardrobe & Hijab</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-600">Rp 600.000+</span>
                        <a href="{{ route('login') }}" class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold">Pesan</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-rose-100 py-6 text-center text-xs text-slate-400">
        &copy; 2026 GlowMUA. All rights reserved.
    </footer>
</body>
</html>