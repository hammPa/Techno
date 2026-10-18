<section class="max-w-6xl mx-auto px-4 sm:px-6 pt-10 pb-12 text-center">
    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold mb-4">
        Platform Direktori & Reservasi MUA Terverifikasi
    </span>
    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight sm:leading-tight">
        Temukan Sentuhan Riasan Sempurna untuk Hari Bahagiamu
    </h1>
    <p class="text-xs sm:text-base text-slate-500 mt-3 max-w-xl mx-auto leading-relaxed">
        Jelajahi karya makeup artist resmi dan terverifikasi identitasnya untuk acara wisuda, wedding, lamaran, hingga photoshoot.
    </p>

    <!-- Search Bar Form -->
    <form action="{{ route('home') }}#katalog" method="GET" class="mt-8 max-w-xl mx-auto bg-white p-2 sm:p-2.5 rounded-2xl shadow-lg shadow-rose-950/5 border border-rose-100 flex items-center gap-2">
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <!-- <span class="pl-2 text-slate-400">x</span> -->
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama MUA, studio, atau kota domisili..." class="w-full text-xs sm:text-sm focus:outline-none bg-transparent">
        @if(request('q'))
            <a href="{{ route('home', array_filter(['category' => request('category')])) }}#katalog" class="text-xs text-slate-400 hover:text-rose-600 px-1">✕</a>
        @endif
        <button type="submit" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition shrink-0">
            Cari
        </button>
    </form>

    <!-- Kategori Cepat -->
    <div class="flex flex-wrap items-center justify-center gap-2 mt-4">
        @php
            $categories = [
                '' => 'Semua',
                'wedding' => 'Wedding',
                'wisuda' => 'Wisuda',
                'engagement' => 'Lamaran',
                'photoshoot' => 'Photoshoot',
            ];
        @endphp
        @foreach($categories as $key => $label)
            <a href="{{ route('home', array_filter(['category' => $key, 'q' => request('q')])) }}#katalog"
               class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ (request('category', '') === $key) ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-rose-50 border border-rose-100/70' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</section>