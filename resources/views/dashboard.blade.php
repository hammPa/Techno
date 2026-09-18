<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex pb-16 md:pb-0 font-sans">

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-60 bg-white border-r border-rose-100 p-5 space-y-6 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold text-sm">✨</span>
            <span class="font-bold text-lg text-slate-900">Glow<span class="text-rose-600">MUA</span></span>
        </a>

        <nav class="flex-1 space-y-1">
            <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs">
                <span>📊</span> Ringkasan
            </a>
            <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>📅</span> Agenda Jadwal
            </a>
            <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>💄</span> Paket & Tarif
            </a>
            <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>💬</span> Pesan
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
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Halo, {{ auth()->user()->name }} 👋</h1>
                <p class="text-xs text-slate-500">Peran: <span class="capitalize font-bold text-rose-600">{{ auth()->user()->role }}</span> • Status: <span class="text-emerald-600 font-semibold">Verified</span></p>
            </div>
            <div class="w-9 h-9 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl text-lg">⏳</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Jadwal Mendatang</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">3 Booking</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl text-lg">✨</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Selesai Dirias</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">18 Sesi</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl text-lg">💰</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Omset Bulan Ini</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Rp 5.250.000</h3>
                </div>
            </div>
        </div>

        <!-- Agenda Booking -->
        <div class="bg-white rounded-2xl border border-rose-100 p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-sm sm:text-base text-slate-900">Jadwal Rias Terdekat</h2>
                <button class="text-xs font-semibold text-rose-600 hover:underline">+ Tambah Sesi</button>
            </div>

            <div class="space-y-3">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-rose-100 text-rose-600 rounded-lg text-base">👰‍♀️</div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-800">Wedding Glam - Amanda Putri</h4>
                            <p class="text-[11px] text-slate-500">Sabtu, 24 Okt • 06:00 WIB</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-2 border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-200">
                        <span class="text-[10px] px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full font-semibold">Confirmed</span>
                        <button class="text-xs px-2.5 py-1 bg-white border border-slate-200 rounded-lg font-medium hover:bg-slate-100">Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-6 py-2 flex items-center justify-between z-50">
        <a href="#" class="flex flex-col items-center text-rose-600">
            <span class="text-base">📊</span>
            <span class="text-[10px] font-semibold mt-0.5">Home</span>
        </a>
        <a href="#" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">📅</span>
            <span class="text-[10px] font-medium mt-0.5">Jadwal</span>
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