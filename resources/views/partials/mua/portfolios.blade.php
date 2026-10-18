{{--
    partials/mua/portfolio.blade.php
    Desain disamakan dengan overview.blade.php. Variabel: $portfolios (field: title, image_url).
--}}
@php
    $inputClass = 'w-full px-3 py-2 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/40';
    $labelClass = 'block mb-1 text-xs font-medium text-[#3b2230]/70';
@endphp

<section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
    <div class="flex items-baseline justify-between gap-4 mb-5">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Foto portofolio</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Unggah hasil rias terbaik untuk menarik calon klien.</p>
        </div>
        <span class="shrink-0 text-sm text-[#3b2230]/60">{{ $portfolios->count() }} foto</span>
    </div>

    <!-- Form upload -->
    <form action="{{ route('mua.portfolio.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 mb-6 border border-[#3b2230]/10 rounded-md bg-[#3b2230]/[0.03]">
        @csrf
        <div>
            <label for="pf-title" class="{{ $labelClass }}">Judul riasan</label>
            <input id="pf-title" type="text" name="title" required placeholder="Contoh: Wisuda flawless glowing" class="{{ $inputClass }}">
        </div>
        <div>
            <label for="pf-image" class="{{ $labelClass }}">File foto (maks. 3 MB)</label>
            <input id="pf-image" type="file" name="image" accept="image/*" required
                class="w-full text-sm text-[#3b2230]/60 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#3b2230]/[0.08] file:text-[#3b2230] hover:file:bg-[#3b2230]/[0.14] file:cursor-pointer">
        </div>
        <div class="sm:self-end">
            <button type="submit"
                class="w-full px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                Unggah foto
            </button>
        </div>
    </form>

    <!-- Galeri -->
    @if($portfolios->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($portfolios as $p)
                @php
                    $src = str_starts_with($p->image_url, 'http') ? $p->image_url : Storage::url($p->image_url);
                @endphp
                <figure class="relative">
                    <div class="aspect-[4/5] overflow-hidden rounded-md bg-[#3b2230]/[0.07]">
                        <img src="{{ $src }}" alt="{{ $p->title }}" loading="lazy" class="w-full h-full object-cover">
                    </div>

                    <form action="{{ route('mua.portfolio.destroy', $p->id) }}" method="POST"
                        class="absolute top-2 right-2" onsubmit="return confirm('Hapus foto ini dari portofolio?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" aria-label="Hapus foto {{ $p->title }}"
                            class="w-7 h-7 flex items-center justify-center rounded-md bg-white/90 text-red-700 hover:bg-white border border-[#3b2230]/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>

                    <figcaption class="mt-2 text-sm truncate">{{ $p->title }}</figcaption>
                </figure>
            @endforeach
        </div>
    @else
        <div class="py-12 text-center border border-dashed border-[#3b2230]/20 rounded-md">
            <p class="text-sm text-[#3b2230]/60">Belum ada foto portofolio. Unggah foto pertama lewat form di atas.</p>
        </div>
    @endif
</section>