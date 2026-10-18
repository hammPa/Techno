@php
    $categories = [
        ''           => 'Semua',
        'wedding'    => 'Wedding',
        'wisuda'     => 'Wisuda',
        'engagement' => 'Lamaran',
        'photoshoot' => 'Photoshoot',
    ];
@endphp

<section class="max-w-6xl mx-auto px-4 sm:px-6 pt-12 sm:pt-16 pb-10">
    <h1 class="max-w-3xl text-4xl sm:text-5xl [font-family:'Fraunces',serif] font-normal leading-[1.1]">
        Temukan sentuhan riasan sempurna untuk hari bahagiamu
    </h1>
    <p class="mt-4 max-w-xl text-base leading-relaxed text-[#3b2230]/65">
        Jelajahi karya makeup artist yang identitasnya sudah terverifikasi, untuk wisuda, wedding, lamaran, hingga photoshoot.
    </p>

    <!-- Pencarian -->
    <form action="{{ route('home') }}#katalog" method="GET" role="search"
        class="mt-8 max-w-xl flex items-center gap-2 p-2 bg-white border border-[#3b2230]/15 rounded-md focus-within:border-[#3b2230]/50 focus-within:ring-2 focus-within:ring-[#3b2230]/30 transition-colors">
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <label for="q" class="sr-only">Cari MUA</label>
        <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama MUA, studio, atau kota"
            class="flex-1 min-w-0 px-2 py-2 bg-transparent border-0 text-sm placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-0">
        @if(request('q'))
            <a href="{{ route('home', array_filter(['category' => request('category')])) }}#katalog" aria-label="Hapus kata kunci"
               class="shrink-0 p-1 text-[#3b2230]/40 hover:text-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        @endif
        <button type="submit"
            class="shrink-0 px-5 py-2 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
            Cari
        </button>
    </form>

    <!-- Kategori cepat -->
    <div class="mt-4 flex flex-wrap items-center gap-2">
        @foreach($categories as $key => $label)
            @php $active = request('category', '') === $key; @endphp
            <a href="{{ route('home', array_filter(['category' => $key, 'q' => request('q')])) }}#katalog"
               @if($active) aria-current="true" @endif
               class="px-3 py-1.5 text-sm font-medium rounded-md border transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40
                      {{ $active ? 'bg-[#3b2230] text-white border-[#3b2230]' : 'bg-white text-[#3b2230]/70 border-[#3b2230]/15 hover:border-[#3b2230]/40 hover:text-[#3b2230]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</section>