@php
    $avgRating   = $mua->mua_reviews_avg_rating ? round($mua->mua_reviews_avg_rating, 1) : null;
    $reviewCount = $mua->mua_reviews_count ?? 0;
    $firstImg    = optional($mua->portfolios->first())->image_url;
    $imgSrc      = $firstImg ? (str_starts_with($firstImg, 'http') ? $firstImg : Storage::url($firstImg)) : null;
@endphp

<article class="flex flex-col justify-between h-full p-5 bg-white border border-[#3b2230]/10 rounded-lg hover:border-[#3b2230]/40 transition-colors">
    <div class="space-y-3">
        <!-- Avatar & verifikasi -->
        <div class="flex items-start justify-between gap-3">
            @if($imgSrc)
                <img src="{{ $imgSrc }}" alt="{{ $mua->name }}" loading="lazy" class="shrink-0 w-12 h-12 rounded-md object-cover bg-[#3b2230]/[0.07]">
            @else
                <div class="shrink-0 w-12 h-12 rounded-md bg-[#3b2230]/[0.07] text-[#3b2230] text-sm font-semibold flex items-center justify-center" aria-hidden="true">
                    {{ strtoupper(substr($mua->name, 0, 2)) }}
                </div>
            @endif

            <span class="shrink-0 inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-emerald-800 bg-emerald-50 rounded-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Terverifikasi
            </span>
        </div>

        <!-- Nama, kota, bio -->
        <div>
            <h3 class="text-lg [font-family:'Fraunces',serif] font-normal leading-snug truncate">
                {{ $mua->muaProfile->studio_name ?? $mua->name }}
            </h3>
            <p class="mt-0.5 text-sm font-medium text-[#3b2230]/80">{{ $mua->muaProfile->city ?? 'Padang' }}</p>
            <p class="mt-0.5 text-sm text-[#3b2230]/60 line-clamp-1">{{ $mua->muaProfile->bio ?? 'Spesialisasi makeup' }}</p>
        </div>

        <!-- Rating -->
        <div class="text-sm">
            @if($avgRating)
                <span class="font-semibold"><span aria-hidden="true">★</span> {{ $avgRating }}</span>
                <span class="text-xs text-[#3b2230]/55">({{ $reviewCount }} ulasan)</span>
            @else
                <span class="text-xs text-[#3b2230]/55">Baru bergabung</span>
            @endif
        </div>

        <!-- Layanan -->
        <div class="flex flex-wrap items-center gap-1.5">
            @forelse($mua->services->take(2) as $service)
                <span class="px-2 py-0.5 text-xs rounded-sm bg-[#3b2230]/[0.07] text-[#3b2230]/75">{{ $service->title }}</span>
            @empty
                <span class="text-xs text-[#3b2230]/55">Konsultasi custom</span>
            @endforelse
            @if($mua->services->count() > 2)
                <span class="text-xs text-[#3b2230]/55">+{{ $mua->services->count() - 2 }}</span>
            @endif
        </div>
    </div>

    <!-- Harga & aksi -->
    <div class="mt-5 pt-4 flex items-end justify-between gap-3 border-t border-[#3b2230]/10">
        <div>
            <span class="block text-xs text-[#3b2230]/55">Mulai dari</span>
            <span class="block mt-0.5 text-base font-semibold">
                @if($mua->services->isNotEmpty())
                    Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                @else
                    Hubungi MUA
                @endif
            </span>
        </div>

        <a href="{{ route('mua.detail', $mua->id) }}"
           class="shrink-0 px-4 py-2 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
            Lihat portofolio
        </a>
    </div>
</article>