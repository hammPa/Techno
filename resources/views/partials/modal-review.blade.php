<div id="reviewModal" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle"
    class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto p-4 bg-[#3b2230]/50">
    <div class="w-full max-w-md p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">

        <div class="flex items-start justify-between gap-4 mb-5">
            <div class="min-w-0">
                <h3 id="reviewModalTitle" class="text-2xl [font-family:'Fraunces',serif] font-normal">Beri ulasan</h3>
                <p id="reviewSubtitle" class="mt-1 text-sm text-[#3b2230]/60 truncate"></p>
            </div>
            <button type="button" onclick="closeReviewModal()" aria-label="Tutup"
                class="shrink-0 p-1 text-[#3b2230]/50 hover:text-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="reviewBookingForm" method="POST" class="space-y-5">
            @csrf

            <!-- Rating -->
            <fieldset>
                <legend class="mb-2 text-sm font-medium text-center w-full text-[#3b2230]/80">Berapa bintang untuk MUA ini?</legend>
                <div class="flex items-center justify-center gap-1" id="starContainer">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" data-val="{{ $i }}"
                            aria-label="{{ $i }} bintang"
                            class="star-btn p-1 text-3xl leading-none text-[#3b2230]/25 rounded-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                            ★
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="selectedRating" value="5" required>
                <p id="ratingLabel" class="mt-1 text-sm text-center text-[#3b2230]/70" aria-live="polite">Sangat memuaskan</p>
            </fieldset>

            <!-- Komentar -->
            <div>
                <label for="comment" class="block mb-1.5 text-sm font-medium text-[#3b2230]/80">
                    Ceritakan pengalaman Anda <span class="font-normal text-[#3b2230]/50">(opsional)</span>
                </label>
                <textarea name="comment" id="comment" rows="3"
                    placeholder="Hasil makeup tahan lama, MUA ramah dan tepat waktu"
                    class="w-full px-3.5 py-2.5 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 resize-none focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/30 transition-colors"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-[#3b2230]/10">
                <button type="button" onclick="closeReviewModal()"
                    class="px-4 py-2.5 text-sm font-semibold text-[#3b2230]/70 hover:text-[#3b2230] hover:bg-[#3b2230]/[0.05] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                    Kirim ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const ratingLabels = {
        1: 'Mengecewakan',
        2: 'Kurang puas',
        3: 'Cukup bagus',
        4: 'Memuaskan',
        5: 'Sangat memuaskan'
    };

    function setRating(val) {
        document.getElementById('selectedRating').value = val;
        document.getElementById('ratingLabel').innerText = `${ratingLabels[val]} (${val} bintang)`;

        document.querySelectorAll('.star-btn').forEach(btn => {
            const filled = parseInt(btn.getAttribute('data-val')) <= val;
            btn.classList.toggle('text-[#3b2230]', filled);
            btn.classList.toggle('text-[#3b2230]/25', !filled);
        });
    }

    function openReviewModal(bookingId, muaName, serviceTitle) {
        const modal = document.getElementById('reviewModal');
        const form = document.getElementById('reviewBookingForm');
        const subtitle = document.getElementById('reviewSubtitle');
        if (!modal || !form) return;

        form.action = `/bookings/${bookingId}/reviews`;
        subtitle.innerText = `${serviceTitle} oleh ${muaName}`;
        setRating(5); // Default 5 bintang
        document.getElementById('comment').value = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    window.addEventListener('click', function (e) {
        if (e.target === document.getElementById('reviewModal')) closeReviewModal();
    });

    window.addEventListener('keydown', function (e) {
        const modal = document.getElementById('reviewModal');
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeReviewModal();
    });
</script>