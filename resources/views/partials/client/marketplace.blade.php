<div>
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-bold text-base text-slate-900">Katalog Pilihan Makeup Artist</h2>
            <p class="text-xs text-slate-400">Pilih MUA dan atur jadwal janji rias langsung</p>
        </div>
        <span class="text-xs font-semibold text-rose-600">{{ $muaList->count() }} Terverifikasi</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($muaList as $mua)
            @php
                $avgRating = $mua->mua_reviews_avg_rating ? round($mua->mua_reviews_avg_rating, 1) : null;
                $reviewCount = $mua->mua_reviews_count ?? 0;
            @endphp

            <div class="bg-white rounded-3xl border border-rose-100 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-rose-50 relative overflow-hidden flex items-center justify-center">
                        @if($mua->portfolios->isNotEmpty() && $mua->portfolios->first()->image_url)
                            @php
                                $firstImg = $mua->portfolios->first()->image_url;
                                $coverSrc = str_starts_with($firstImg, 'http') ? $firstImg : Storage::url($firstImg);
                            @endphp
                            <img src="{{ $coverSrc }}" alt="{{ $mua->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">🪞</span>
                        @endif

                        <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-700">
                            📍 {{ $mua->muaProfile->city ?? 'Indonesia' }}
                        </span>

                        <!-- Badge Terverifikasi Resmi -->
                        <span class="absolute top-3 right-3 bg-emerald-500/90 text-white backdrop-blur-md px-2 py-0.5 rounded-lg text-[10px] font-bold shadow-xs flex items-center gap-1">
                            ✓ Terverifikasi
                        </span>
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-bold text-base text-slate-900 truncate">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h3>
                            
                            <!-- Rating Ulasan Klien -->
                            @if($avgRating)
                                <span class="text-xs font-bold text-amber-500 flex items-center gap-0.5">
                                    ★ {{ $avgRating }}
                                    <span class="text-[10px] text-slate-400 font-normal">({{ $reviewCount }})</span>
                                </span>
                            @else
                                <span class="text-[10px] font-medium text-slate-400">
                                    Baru bergabung
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400">Artisan: {{ $mua->name }}</p>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                            {{ $mua->muaProfile->bio ?? 'Tersedia layanan makeup wisuda, bridal, photoshoot, dan pesta.' }}
                        </p>

                        <div class="flex flex-wrap gap-1.5 mt-3">
                            @forelse($mua->services->take(2) as $s)
                                <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-medium">
                                    {{ $s->title }}
                                </span>
                            @empty
                                <span class="text-[10px] text-slate-400 italic">Belum ada paket</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Tarif Mulai</span>
                            <span class="text-xs sm:text-sm font-extrabold text-rose-600">
                                @if($mua->services->isNotEmpty())
                                    Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                                @else
                                    Hubungi MUA
                                @endif
                            </span>
                        </div>
                        <a href="{{ route('mua.detail', $mua->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                            Portofolio & Booking →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-rose-100">
                <span class="text-3xl block mb-2">💄</span>
                <p class="text-xs font-semibold text-slate-700">Belum ada MUA terverifikasi yang tersedia.</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Silakan periksa kembali beberapa saat lagi.</p>
            </div>
        @endforelse
    </div>
</div>