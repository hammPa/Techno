<!-- Modal Beri Ulasan MUA -->
<div id="reviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-slate-100 transition-all">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">Beri Ulasan Layanan</h3>
                <p id="reviewSubtitle" class="text-[11px] text-slate-500 mt-0.5"></p>
            </div>
            <button type="button" onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
        </div>

        <form id="reviewBookingForm" method="POST" class="mt-4 space-y-4">
            @csrf

            <!-- Pilihan Bintang Rating -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 text-center">Berapa bintang untuk MUA ini?</label>
                <div class="flex items-center justify-center gap-2" id="starContainer">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" class="star-btn text-2xl text-slate-300 hover:scale-110 transition" data-val="{{ $i }}">
                            ★
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="selectedRating" value="5" required>
                <p id="ratingLabel" class="text-center text-xs font-bold text-amber-500 mt-1">Sangat Memuaskan (5 Bintang)</p>
            </div>

            <!-- Komentar Ulasan -->
            <div>
                <label for="comment" class="block text-xs font-bold text-slate-700 mb-1">
                    Ceritakan Pengalaman Anda <span class="text-slate-400 font-normal">(opsional)</span>
                </label>
                <textarea 
                    name="comment" 
                    id="comment" 
                    rows="3" 
                    placeholder="Hasil makeup tahan lama, MUA ramah dan tepat waktu..." 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-rose-500 focus:bg-white resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeReviewModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const ratingLabels = {
        1: 'Mengecewakan (1 Bintang)',
        2: 'Kurang Puas (2 Bintang)',
        3: 'Cukup Bagus (3 Bintang)',
        4: 'Memuaskan (4 Bintang)',
        5: 'Sangat Memuaskan (5 Bintang)'
    };

    function setRating(val) {
        document.getElementById('selectedRating').value = val;
        document.getElementById('ratingLabel').innerText = ratingLabels[val];

        document.querySelectorAll('.star-btn').forEach(btn => {
            const btnVal = parseInt(btn.getAttribute('data-val'));
            if (btnVal <= val) {
                btn.classList.remove('text-slate-300');
                btn.classList.add('text-amber-400');
            } else {
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-slate-300');
            }
        });
    }

    function openReviewModal(bookingId, muaName, serviceTitle) {
        const modal = document.getElementById('reviewModal');
        const form = document.getElementById('reviewBookingForm');
        const subtitle = document.getElementById('reviewSubtitle');

        if (modal && form) {
            form.action = `/bookings/${bookingId}/reviews`;
            subtitle.innerText = `${serviceTitle} • ${muaName}`;
            setRating(5); // Default 5 bintang
            document.getElementById('comment').value = '';
            modal.classList.remove('hidden');
        }
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        if (modal) modal.classList.add('hidden');
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('reviewModal');
        if (e.target === modal) closeReviewModal();
    });
</script>