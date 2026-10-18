{{-- partials/client/booking/completed-review.blade.php  |  butuh: $b --}}
<div class="p-5 bg-white border border-[#3b2230]/10 rounded-md">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <p class="text-sm font-medium">Layanan selesai dilaksanakan. Terima kasih telah menggunakan TemuMUA!</p>

        @if(!$b->review)
            <button type="button"
                onclick="openReviewModal(@js((string) $b->id), @js($b->mua->muaProfile->studio_name ?? $b->mua->name), @js($b->service->title))"
                class="shrink-0 px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] text-[#faf6f1] rounded-md text-sm font-medium whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">
                Beri ulasan MUA
            </button>
        @endif
    </div>

    @if($b->review)
        <div class="mt-4 pt-4 border-t border-[#3b2230]/10 flex flex-col sm:flex-row sm:items-start justify-between gap-2">
            <div>
                <div class="flex items-center gap-1 text-sm" aria-label="Rating {{ $b->review->rating }} dari 5">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $b->review->rating ? '' : 'text-[#3b2230]/25' }}">★</span>
                    @endfor
                    <span class="ml-1.5 text-xs text-[#3b2230]/65">{{ $b->review->rating }}.0 / 5.0</span>
                </div>
                @if($b->review->comment)
                    <p class="mt-1.5 text-sm italic text-[#3b2230]/80">“{{ $b->review->comment }}”</p>
                @endif
            </div>
            <span class="text-xs text-[#3b2230]/50">Diulas pada {{ $b->review->created_at->format('d-m-Y') }}</span>
        </div>
    @endif
</div>
