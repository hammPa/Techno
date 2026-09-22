<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUA Dashboard - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex pb-20 md:pb-0 font-sans">

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-60 bg-white border-r border-rose-100 p-5 space-y-6 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">✨</span>
            <span class="font-bold text-lg text-slate-900">Glow<span class="text-rose-600">MUA</span></span>
        </a>

        <div class="px-3 py-2 bg-rose-50/80 rounded-xl border border-rose-100/60">
            <span class="text-[10px] uppercase font-bold text-rose-600 tracking-wider block">Mode Partner MUA</span>
            <span class="text-xs font-semibold text-slate-800 truncate block">{{ $user->name }}</span>
        </div>

        <!-- Desktop Navigation Tabs -->
        <nav class="flex-1 space-y-1">
            <button type="button" onclick="switchTab('ringkasan')" id="btn-tab-ringkasan"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs transition">
                <span>📊</span> Ringkasan
            </button>
            <button type="button" onclick="switchTab('reservasi')" id="btn-tab-reservasi"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>📅</span> Reservasi
                @if($bookings->where('status', 'pending')->count() > 0)
                    <span class="ml-auto px-1.5 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-800 rounded-md">
                        {{ $bookings->where('status', 'pending')->count() }}
                    </span>
                @endif
            </button>
            <button type="button" onclick="switchTab('saldo')" id="btn-tab-saldo"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>💸</span> Tarik Saldo
            </button>
            <button type="button" onclick="switchTab('paket')" id="btn-tab-paket"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>💄</span> Paket Rias
                <span class="ml-auto text-[10px] text-slate-400 font-semibold">{{ $services->count() }}</span>
            </button>
            <button type="button" onclick="switchTab('profil')" id="btn-tab-profil"
                class="tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>⚙️</span> Profil & Portofolio
            </button>
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
        <!-- Top Bar -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Studio: {{ $profile->studio_name ?? $user->name }} 👋</h1>
                <p class="text-xs text-slate-500">Kelola reservasi masuk, selesaikan job dengan kode verifikasi, dan kelola portofolio</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase shadow-sm">
                {{ substr($user->name, 0, 2) }}
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-xs">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        @include('partials.mua.verification-banner')

        <!-- Tab Contents -->
        <div id="content-ringkasan" class="tab-content">
            @include('partials.mua.overview')
        </div>

        <div id="content-reservasi" class="tab-content hidden">
            @include('partials.mua.reservations')
        </div>

        <div id="content-saldo" class="tab-content hidden">
            @include('partials.mua.payout')
        </div>

        <div id="content-paket" class="tab-content hidden">
            @include('partials.mua.services')
        </div>

        <div id="content-profil" class="tab-content hidden">
            @include('partials.mua.profile')
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-4 py-2 flex items-center justify-between z-50">
        <button type="button" onclick="switchTab('ringkasan')" id="btn-mobile-ringkasan" class="mobile-tab-btn flex flex-col items-center text-rose-600">
            <span class="text-base">📊</span>
            <span class="text-[10px] font-semibold mt-0.5">Ringkasan</span>
        </button>
        <button type="button" onclick="switchTab('reservasi')" id="btn-mobile-reservasi" class="mobile-tab-btn flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">📅</span>
            <span class="text-[10px] font-medium mt-0.5">Reservasi</span>
        </button>
        <button type="button" onclick="switchTab('saldo')" id="btn-mobile-saldo" class="mobile-tab-btn flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">💸</span>
            <span class="text-[10px] font-medium mt-0.5">Saldo</span>
        </button>
        <button type="button" onclick="switchTab('paket')" id="btn-mobile-paket" class="mobile-tab-btn flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">💄</span>
            <span class="text-[10px] font-medium mt-0.5">Paket</span>
        </button>
        <button type="button" onclick="switchTab('profil')" id="btn-mobile-profil" class="mobile-tab-btn flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">⚙️</span>
            <span class="text-[10px] font-medium mt-0.5">Profil</span>
        </button>
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
        const validTabs = ['ringkasan', 'reservasi', 'saldo', 'paket', 'profil'];

        function switchTab(tab) {
            if (!validTabs.includes(tab)) tab = 'ringkasan';

            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

            // Show selected tab content
            const activeContent = document.getElementById(`content-${tab}`);
            if (activeContent) activeContent.classList.remove('hidden');

            // Reset Desktop Sidebar Buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-rose-50', 'text-rose-700', 'font-semibold');
                btn.classList.add('text-slate-600', 'font-medium');
            });
            const activeDesktopBtn = document.getElementById(`btn-tab-${tab}`);
            if (activeDesktopBtn) {
                activeDesktopBtn.classList.remove('text-slate-600', 'font-medium');
                activeDesktopBtn.classList.add('bg-rose-50', 'text-rose-700', 'font-semibold');
            }

            // Reset Mobile Bottom Nav Buttons
            document.querySelectorAll('.mobile-tab-btn').forEach(btn => {
                btn.classList.remove('text-rose-600');
                btn.classList.add('text-slate-400');
            });
            const activeMobileBtn = document.getElementById(`btn-mobile-${tab}`);
            if (activeMobileBtn) {
                activeMobileBtn.classList.remove('text-slate-400');
                activeMobileBtn.classList.add('text-rose-600');
            }

            // Sync URL hash
            history.replaceState(null, null, `#${tab}`);
        }

        // Handle direct links or browser back/forward buttons with hash
        window.addEventListener('hashchange', () => {
            const hash = window.location.hash.replace('#', '');
            if (hash) switchTab(hash);
        });

        // Initialize active tab on first load
        document.addEventListener('DOMContentLoaded', () => {
            const initialHash = window.location.hash.replace('#', '');
            if (validTabs.includes(initialHash)) {
                switchTab(initialHash);
            }
        });
    </script>

    @include('partials.modal-cancel-booking')
</body>
</html>