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

        <!-- Desktop Navigation Tabs -->
        <nav class="flex-1 space-y-1">
            <button type="button" onclick="switchTab('marketplace')" id="btn-tab-marketplace"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-xs transition bg-rose-50 text-rose-700">
                <span>🛍</span> Katalog MUA
            </button>
            <button type="button" onclick="switchTab('bookings')" id="btn-tab-bookings"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition text-slate-600 hover:bg-rose-50/50">
                <span>📅</span> Reservasi Saya
                @if($myBookings->count() > 0)
                    <span class="ml-auto px-1.5 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-700 rounded-md">
                        {{ $myBookings->count() }}
                    </span>
                @endif
            </button>
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
                <p class="text-xs text-slate-500">Pantau status reservasi riasan, pembayaran, dan cari MUA favoritmu</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase shadow-sm">
                {{ substr($user->name, 0, 2) }}
            </a>
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

        <!-- Tab Contents -->
        <div id="content-marketplace" class="tab-content">
            @include('partials.client.marketplace')
        </div>

        <div id="content-bookings" class="tab-content hidden">
            @include('partials.client.bookings')
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-6 py-2 flex items-center justify-between z-50">
        <button type="button" onclick="switchTab('marketplace')" id="btn-mobile-marketplace" class="mobile-tab-btn flex flex-col items-center text-rose-600">
            <span class="text-base">🛍</span>
            <span class="text-[10px] font-semibold mt-0.5">Katalog</span>
        </button>
        <button type="button" onclick="switchTab('bookings')" id="btn-mobile-bookings" class="mobile-tab-btn flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">📅</span>
            <span class="text-[10px] font-medium mt-0.5">Reservasi</span>
        </button>
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

    <!-- Tab Control Script -->
    <script>
        function switchTab(tab) {
            // Hide all tab sections
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

            // Show selected section
            const activeContent = document.getElementById(`content-${tab}`);
            if (activeContent) activeContent.classList.remove('hidden');

            // Reset Desktop Sidebar Buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition";
            });
            const activeDesktopBtn = document.getElementById(`btn-tab-${tab}`);
            if (activeDesktopBtn) {
                activeDesktopBtn.className = "tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs transition";
            }

            // Reset Mobile Bottom Nav Buttons
            document.querySelectorAll('.mobile-tab-btn').forEach(btn => {
                btn.className = "mobile-tab-btn flex flex-col items-center text-slate-400 hover:text-rose-600";
            });
            const activeMobileBtn = document.getElementById(`btn-mobile-${tab}`);
            if (activeMobileBtn) {
                activeMobileBtn.className = "mobile-tab-btn flex flex-col items-center text-rose-600";
            }

            // Sync URL hash for refresh/bookmark support
            history.replaceState(null, null, `#${tab}`);
        }

        // On initial page load: auto-open tab if URL has hash (misal: #bookings)
        document.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            if (hash === 'bookings' || hash === 'marketplace') {
                switchTab(hash);
            }
        });
    </script>

    @include('partials.modal-cancel-booking')
    @include('partials.modal-review')
</body>
</html>