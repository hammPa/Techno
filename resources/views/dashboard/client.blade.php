<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Dashboard Klien - TemuMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,400;9..144,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] [font-family:'DM_Sans',system-ui,sans-serif] antialiased min-h-screen md:flex pb-20 md:pb-0">

    <!-- Sidebar Desktop -->
    <aside class="hidden md:flex flex-col w-64 shrink-0 md:sticky md:top-0 md:h-screen px-6 py-8 bg-[#f3ece4] border-r border-[#3b2230]/10">
        <a href="{{ route('home') }}" class="text-2xl [font-family:'Fraunces',serif] tracking-tight hover:opacity-80 transition-opacity focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40 rounded-sm">
            TemuMUA
        </a>

        <div class="mt-10 pb-6 border-b border-[#3b2230]/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#3b2230] text-[#faf6f1] flex items-center justify-center font-medium text-sm uppercase shrink-0">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div class="min-w-0 flex-1">
                <span class="block text-xs text-[#3b2230]/55">Masuk sebagai klien</span>
                <span class="block text-sm font-semibold truncate">{{ $user->name }}</span>
            </div>
        </div>

        <nav class="mt-6 flex-1 space-y-1" aria-label="Navigasi utama">
            <button type="button" onclick="switchTab('marketplace')" id="btn-tab-marketplace" aria-current="page"
                class="tab-btn w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>Katalog MUA</span>
            </button>

            <button type="button" onclick="switchTab('bookings')" id="btn-tab-bookings"
                class="tab-btn group w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] aria-[current=page]:bg-[#3b2230] aria-[current=page]:text-[#faf6f1] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="flex-1 text-left">Reservasi saya</span>
                @if($myBookings->count() > 0)
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-[#3b2230]/10 group-aria-[current=page]:bg-[#faf6f1]/20 group-aria-[current=page]:text-[#faf6f1]">
                        {{ $myBookings->count() }}
                    </span>
                @endif
            </button>
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="pt-4 border-t border-[#3b2230]/10">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-[#3b2230]/70 hover:bg-[#3b2230]/[0.06] hover:text-[#3b2230] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 max-w-6xl mx-auto px-5 py-8 sm:px-8 lg:px-12 lg:py-12 w-full min-w-0">

        <header class="flex items-start justify-between gap-4 mb-10">
            <div class="min-w-0">
                <h1 class="text-3xl lg:text-4xl leading-tight [font-family:'Fraunces',serif] font-normal">
                    Halo, {{ $user->name }}
                </h1>
                <p class="mt-2 text-sm text-[#3b2230]/60 max-w-xl">
                    Pantau status reservasi, pembayaran, dan temukan makeup artist impianmu.
                </p>
            </div>
            <a href="{{ route('profile.edit') }}"
                class="shrink-0 px-4 py-2.5 text-sm font-medium rounded-md bg-[#3b2230] text-[#faf6f1] hover:bg-[#2a1620] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-[#faf6f1] focus-visible:ring-[#3b2230]">
                Edit profil
            </a>
        </header>

        <!-- Pesan -->
        @if(session('success'))
            <div role="status" class="mb-6 px-4 py-3 border-l-2 border-[#4d7a5a] bg-[#e5eee6] text-sm text-[#2f5a3c]">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="mb-6 px-4 py-3 border-l-2 border-[#a23b3b] bg-[#f4e3df] text-sm text-[#7a2a2a]">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Isi Tab -->
        <div id="content-marketplace" class="tab-content">
            @include('partials.client.marketplace')
        </div>

        <div id="content-bookings" class="tab-content hidden">
            @include('partials.client.bookings')
        </div>
    </main>

    <!-- Navigasi Bawah (Mobile) -->
    <nav aria-label="Navigasi utama" class="md:hidden fixed bottom-0 inset-x-0 z-50 px-2 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] flex items-stretch bg-[#faf6f1]/95 backdrop-blur border-t border-[#3b2230]/10">
        <button type="button" onclick="switchTab('marketplace')" id="btn-mobile-marketplace" aria-current="page"
            class="mobile-tab-btn flex-1 flex flex-col items-center gap-1 py-1.5 text-[#3b2230]/50 aria-[current=page]:text-[#3b2230] aria-[current=page]:font-semibold transition-colors focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="text-[11px]">Katalog</span>
        </button>

        <button type="button" onclick="switchTab('bookings')" id="btn-mobile-bookings"
            class="mobile-tab-btn flex-1 flex flex-col items-center gap-1 py-1.5 text-[#3b2230]/50 aria-[current=page]:text-[#3b2230] aria-[current=page]:font-semibold transition-colors focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-[11px]">Reservasi</span>
        </button>

        <form action="{{ route('logout') }}" method="POST" class="flex-1 flex">
            @csrf
            <button type="submit"
                class="flex-1 flex flex-col items-center gap-1 py-1.5 text-[#3b2230]/50 hover:text-[#3b2230] transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="text-[11px]">Keluar</span>
            </button>
        </form>
    </nav>

    <script>
        const validTabs = ['marketplace', 'bookings'];

        function switchTab(tab) {
            if (!validTabs.includes(tab)) tab = 'marketplace';

            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            const activeContent = document.getElementById(`content-${tab}`);
            if (activeContent) activeContent.classList.remove('hidden');

            document.querySelectorAll('.tab-btn, .mobile-tab-btn').forEach(btn => {
                const on = btn.id === `btn-tab-${tab}` || btn.id === `btn-mobile-${tab}`;
                if (on) btn.setAttribute('aria-current', 'page'); else btn.removeAttribute('aria-current');
            });

            history.replaceState(null, null, `#${tab}`);
        }

        window.addEventListener('hashchange', () => {
            const hash = window.location.hash.replace('#', '');
            if (validTabs.includes(hash)) switchTab(hash);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            if (validTabs.includes(hash)) switchTab(hash);
        });
    </script>

    @include('partials.modal-cancel-booking')
    @include('partials.modal-review')
</body>
</html>