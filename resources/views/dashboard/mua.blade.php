<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUA Dashboard - GlowMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,400;9..144,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] [font-family:'DM_Sans',system-ui,sans-serif] antialiased min-h-screen md:flex pb-20 md:pb-0">

    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex flex-col w-64 shrink-0 md:sticky md:top-0 md:h-screen bg-[#f3ece4] border-r border-[#3b2230]/10 px-6 py-8">
        <a href="{{ route('home') }}" class="text-2xl [font-family:'Fraunces',serif] tracking-tight">GlowMUA</a>

        <div class="mt-10 pb-6 border-b border-[#3b2230]/10">
            <span class="block text-xs text-[#3b2230]/55">Masuk sebagai partner MUA</span>
            <span class="mt-1 block text-sm font-semibold truncate">{{ $user->name }}</span>
        </div>

        <nav class="mt-6 flex-1 space-y-1" aria-label="Menu dashboard">
            <button type="button" data-tab="ringkasan" onclick="switchTab('ringkasan')" aria-current="page"
                class="w-full text-left px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                Ringkasan
            </button>
            <button type="button" data-tab="jadwal" onclick="switchTab('jadwal')"
                class="w-full text-left px-3 py-2.5 rounded-md text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] transition-colors aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                Jadwal kerja
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
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-[#faf6f1]/95 backdrop-blur border-t border-[#3b2230]/10 flex" aria-label="Menu dashboard">
        <button type="button" data-tab="ringkasan" onclick="switchTab('ringkasan')" aria-current="page"
            class="flex-1 px-2 py-3.5 text-[0.7rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">Ringkasan</button>
        <button type="button" data-tab="jadwal" onclick="switchTab('jadwal')"
            class="flex-1 px-2 py-3.5 text-[0.7rem] font-medium text-[#3b2230]/50 border-t-2 border-transparent transition-colors aria-[current=page]:text-[#3b2230] aria-[current=page]:border-[#3b2230]">Jadwal</button>
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