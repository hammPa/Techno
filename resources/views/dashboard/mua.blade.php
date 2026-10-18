<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUA Dashboard - TemuMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,400;9..144,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] [font-family:'DM_Sans',system-ui,sans-serif] antialiased min-h-screen md:flex pb-20 md:pb-0">

    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex flex-col w-64 shrink-0 md:sticky md:top-0 md:h-screen bg-[#f3ece4] border-r border-[#3b2230]/10 px-6 py-8 overflow-y-auto">
        <a href="{{ route('home') }}" class="text-2xl [font-family:'Fraunces',serif] tracking-tight">TemuMUA</a>

        <div class="mt-8 pb-6 border-b border-[#3b2230]/10">
            <span class="block text-xs text-[#3b2230]/55">Masuk sebagai partner MUA</span>
            <span class="mt-1 block text-sm font-semibold truncate">{{ $user->name }}</span>
        </div>

        <nav class="mt-6 flex-1 space-y-1.5" aria-label="Menu dashboard">
            <!-- Ringkasan -->
            <button type="button" data-tab="ringkasan" onclick="switchTab('ringkasan')" aria-current="page"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <span>Ringkasan</span>
            </button>

            <!-- Reservasi -->
            <button type="button" data-tab="reservasi" onclick="switchTab('reservasi')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5M12 3.75v16.5M7.5 3.75V16.5M3.75 6h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 16.5v-9A1.5 1.5 0 013.75 6z" />
                </svg>
                <span>Reservasi</span>
            </button>

            <!-- Jadwal -->
            <button type="button" data-tab="jadwal" onclick="switchTab('jadwal')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span>Jadwal Kerja</span>
            </button>

            <!-- Saldo / Payout -->
            <button type="button" data-tab="saldo" onclick="switchTab('saldo')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 15V6a1.5 1.5 0 011.5-1.5zm13.5 4.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>
                <span>Saldo & Pencairan</span>
            </button>

            <!-- Layanan / Paket -->
            <button type="button" data-tab="paket" onclick="switchTab('paket')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v1.287" />
                </svg>
                <span>Paket Layanan</span>
            </button>

            <!-- Profil MUA -->
            <button type="button" data-tab="profil" onclick="switchTab('profil')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Profil MUA</span>
            </button>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 min-w-0 max-w-6xl mx-auto w-full px-5 py-8 sm:px-8 lg:px-12 lg:py-12">

        <!-- Header -->
        <header class="flex items-start justify-between gap-4 mb-10">
            <div class="min-w-0">
                <h1 class="text-3xl lg:text-4xl leading-tight [font-family:'Fraunces',serif] font-normal">
                    Halo, {{ $user->name }}
                </h1>
                <p class="mt-2 text-sm text-[#3b2230]/60 max-w-xl">
                    Kelola reservasi, selesaikan job dan kelola portofolio.
                </p>
            </div>
            <a href="{{ route('profile.edit') }}" aria-label="Edit profil"
                class="shrink-0 w-11 h-11 rounded-full bg-[#3b2230] text-[#faf6f1] text-sm font-medium uppercase flex items-center justify-center hover:bg-[#2a1620] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-[#faf6f1] focus-visible:ring-[#3b2230]">
                {{ substr($user->name, 0, 2) }}
            </a>
        </header>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 border-l-2 border-[#4d7a5a] bg-[#e5eee6] text-sm text-[#2f5a3c]">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 px-4 py-3 border-l-2 border-[#a23b3b] bg-[#f4e3df] text-sm text-[#7a2a2a]">
                {{ $errors->first() }}
            </div>
        @endif

        @include('partials.mua.verification-banner')

        <!-- Isi Tab -->
        <div id="content-ringkasan" class="tab-content">
            @include('partials.mua.overview')
        </div>

        <div id="content-reservasi" class="tab-content hidden">
            @include('partials.mua.reservations')
        </div>

        <div id="content-jadwal" class="tab-content hidden">
            @include('partials.mua.schedules')
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

    <!-- Navigasi Bawah (Mobile) -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-[#faf6f1]/95 backdrop-blur border-t border-[#3b2230]/10 flex items-center justify-around py-1" aria-label="Menu dashboard">
        <button type="button" data-tab="ringkasan" onclick="switchTab('ringkasan')" aria-current="page"
            class="flex-1 flex flex-col items-center gap-1 py-2 text-[0.65rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span>Ringkasan</span>
        </button>

        <button type="button" data-tab="reservasi" onclick="switchTab('reservasi')"
            class="flex-1 flex flex-col items-center gap-1 py-2 text-[0.65rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5M12 3.75v16.5M7.5 3.75V16.5M3.75 6h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 16.5v-9A1.5 1.5 0 013.75 6z" />
            </svg>
            <span>Reservasi</span>
        </button>

        <button type="button" data-tab="jadwal" onclick="switchTab('jadwal')"
            class="flex-1 flex flex-col items-center gap-1 py-2 text-[0.65rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <span>Jadwal</span>
        </button>

        <button type="button" data-tab="saldo" onclick="switchTab('saldo')"
            class="flex-1 flex flex-col items-center gap-1 py-2 text-[0.65rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 15V6a1.5 1.5 0 011.5-1.5zm13.5 4.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
            </svg>
            <span>Saldo</span>
        </button>

        <button type="button" data-tab="profil" onclick="switchTab('profil')"
            class="flex-1 flex flex-col items-center gap-1 py-2 text-[0.65rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span>Profil</span>
        </button>
    </nav>

    <!-- Kontrol Tab -->
    <script>
        const validTabs = ['ringkasan', 'reservasi', 'jadwal', 'saldo', 'paket', 'profil'];

        function switchTab(tab) {
            if (!validTabs.includes(tab)) tab = 'ringkasan';

            // Tampilkan konten tab yang dipilih saja
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            const activeContent = document.getElementById(`content-${tab}`);
            if (activeContent) activeContent.classList.remove('hidden');

            // Tandai tombol aktif (sidebar dan navigasi mobile) lewat aria-current
            document.querySelectorAll('[data-tab]').forEach(btn => {
                if (btn.dataset.tab === tab) {
                    btn.setAttribute('aria-current', 'page');
                } else {
                    btn.removeAttribute('aria-current');
                }
            });

            // Sinkronisasi hash URL
            history.replaceState(null, null, `#${tab}`);
        }

        window.addEventListener('hashchange', () => {
            const hash = window.location.hash.replace('#', '');
            if (hash) switchTab(hash);
        });

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