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