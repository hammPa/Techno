@php
    $avgRating = $mua->mua_reviews_avg_rating ? round($mua->mua_reviews_avg_rating, 1) : null;
    $reviewCount = $mua->mua_reviews_count ?? 0;
@endphp

<div class="bg-white rounded-2xl border border-rose-100 p-4 shadow-xs hover:shadow-md transition duration-200 flex flex-col justify-between h-full group">
    <!-- Section Atas: Header & Profil MUA -->
    <div class="flex flex-col gap-3">
        <!-- Top Bar: Avatar & Badge Terverifikasi -->
        <div class="flex items-start justify-between gap-2">
            <div class="relative shrink-0">
                @if($mua->portfolios->isNotEmpty() && $mua->portfolios->first()->image_url)
                    @php
                        $firstImg = $mua->portfolios->first()->image_url;
                        $imgSrc = str_starts_with($firstImg, 'http') ? $firstImg : Storage::url($firstImg);
                    @endphp
                    <img src="{{ $imgSrc }}" alt="{{ $mua->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-rose-100 shadow-xs">
                @else
                    <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 font-bold flex items-center justify-center text-sm border-2 border-rose-100 shadow-xs">
                        {{ strtoupper(substr($mua->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <!-- Badge Terverifikasi -->
            <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-1 rounded-md font-semibold shrink-0 flex items-center gap-1 border border-emerald-100">
                ✓ Terverifikasi
            </span>
        </div>

        <!-- Info Nama, Kota, & Bio -->
        <div>
            <h3 class="font-bold text-sm lg:text-base text-slate-900 truncate leading-snug group-hover:text-rose-600 transition-colors">
                {{ $mua->muaProfile->studio_name ?? $mua->name }}
            </h3>
            
            <p class="text-xs text-slate-500 mt-1 line-clamp-1">
                <span class="font-medium text-slate-700">{{ $mua->muaProfile->city ?? 'Padang' }}</span>
                <span class="mx-1 text-slate-300">•</span>
                <span>{{ $mua->muaProfile->bio ?? 'Spesialisasi Makeup' }}</span>
            </p>
        </div>

        <!-- Rating & Badges Service -->
        <div class="space-y-2 pt-1">
            <!-- Rating -->
            <div>
                @if($avgRating)
                    <div class="text-xs font-bold text-amber-500 flex items-center gap-1">
                        <span>★ {{ $avgRating }}</span>
                        <span class="text-[10px] text-slate-400 font-normal">({{ $reviewCount }} ulasan)</span>
                    </div>
                @else
                    <span class="text-[10px] font-medium text-slate-400">Baru bergabung</span>
                @endif
            </div>

            <!-- Tags Layanan -->
            <div class="flex flex-wrap gap-1">
                @forelse($mua->services->take(2) as $service)
                    <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-medium border border-rose-100/50">
                        {{ $service->title }}
                    </span>
                @empty
                    <span class="text-[10px] text-slate-400 italic">Konsultasi custom</span>
                @endforelse
                @if($mua->services->count() > 2)
                    <span class="text-[10px] text-slate-400 font-medium self-center">
                        +{{ $mua->services->count() - 2 }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Section Bawah: Harga & Tombol -->
    <div class="border-t border-slate-100 pt-3 mt-4 flex items-end justify-between gap-2">
        <div>
            <span class="text-[10px] text-slate-400 block leading-none">Mulai dari</span>
            <span class="text-xs sm:text-sm lg:text-base font-extrabold text-rose-600 block mt-1">
                @if($mua->services->isNotEmpty())
                    Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                @else
                    Hubungi MUA
                @endif
            </span>
        </div>

        <a href="{{ route('mua.detail', $mua->id) }}" class="px-3 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition-all shrink-0 text-center shadow-xs">
            Portofolio
        </a>
    </div>
</div>