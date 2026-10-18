<header class="sticky top-0 z-40 bg-white border-b border-[#3b2230]/10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-2xl [font-family:'Fraunces',serif] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
            TemuMUA
        </a>

        <nav class="flex items-center gap-4" aria-label="Akun">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                    Dashboard saya
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-[#3b2230]/70 hover:text-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                    Daftar akun
                </a>
            @endauth
        </nav>
    </div>
</header>