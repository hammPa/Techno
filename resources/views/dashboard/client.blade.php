<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eksplor MUA - Marketplace</title>
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
                <span>🛍</span> Marketplace MUA
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
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Cari Makeup Artist Pilihan 💄</h1>
                <p class="text-xs text-slate-500">Pilih MUA, lihat portofolio karya, dan hubungi langsung via WhatsApp</p>
            </div>
            <span class="px-3 py-1.5 bg-white border border-rose-200 text-rose-700 rounded-full text-xs font-semibold self-start sm:self-auto">
                {{ $muaList->count() }} MUA Tersedia
            </span>
        </div>

        <!-- Grid Marketplace MUA -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($muaList as $mua)
                <div class="bg-white rounded-3xl border border-rose-100/90 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Preview Portofolio Teratas -->
                        <div class="h-44 bg-gradient-to-tr from-rose-100 to-pink-50 relative overflow-hidden flex items-center justify-center">
                            @if($mua->portfolios->count() > 0 && $mua->portfolios->first()->image_url)
                                <img src="{{ $mua->portfolios->first()->image_url }}" alt="{{ $mua->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">🪞</span>
                            @endif
                            <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-700 shadow-xs">
                                📍 {{ $mua->muaProfile->city ?? 'Indonesia' }}
                            </span>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-base text-slate-900 truncate">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h3>
                                <span class="text-xs font-bold text-amber-500">★ 5.0</span>
                            </div>
                            <p class="text-xs text-slate-400">Oleh: {{ $mua->name }}</p>
                            <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                {{ $mua->muaProfile->bio ?? 'Tersedia layanan makeup wisuda, bridal, photoshoot, dan pesta.' }}
                            </p>

                            <!-- Mini Tags Paket Layanan -->
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @forelse($mua->services->take(2) as $s)
                                    <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-medium">
                                        {{ $s->title }}
                                    </span>
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">Belum pasang paket</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Tarif Mulai</span>
                                <span class="text-xs sm:text-sm font-extrabold text-rose-600">
                                    @if($mua->services->count() > 0)
                                        Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                                    @else
                                        Rp Hubungi MUA
                                    @endif
                                </span>
                            </div>
                            <a href="{{ route('mua.detail', $mua->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                                Lihat Portofolio →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-rose-100">
                    <span class="text-4xl block mb-2">💄</span>
                    <h3 class="font-bold text-sm text-slate-800">Belum Ada Akun MUA Terdaftar</h3>
                    <p class="text-xs text-slate-400 mt-1">Daftarkan akun baru dengan role MUA untuk melihatnya muncul di marketplace ini.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-6 py-2 flex items-center justify-between z-50">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-rose-600">
            <span class="text-base">🛍</span>
            <span class="text-[10px] font-semibold mt-0.5">MUA</span>
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