<div id="cancelModal" role="dialog" aria-modal="true" aria-labelledby="cancelModalTitle"
    class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto p-4 bg-[#3b2230]/50">
    <div class="w-full max-w-md p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">

        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h3 id="cancelModalTitle" class="text-2xl [font-family:'Fraunces',serif] font-normal">Batalkan reservasi</h3>
                <p class="mt-1 text-sm text-[#3b2230]/60">Alasan ini dicatat di riwayat reservasi.</p>
            </div>
            <button type="button" onclick="closeCancelModal()" aria-label="Tutup"
                class="shrink-0 p-1 text-[#3b2230]/50 hover:text-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="cancelBookingForm" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="cancellation_reason" class="block mb-1.5 text-sm font-medium text-[#3b2230]/80">
                    Alasan pembatalan
                </label>
                <textarea name="cancellation_reason" id="cancellation_reason" rows="3" required
                    placeholder="Tulis alasan pembatalan pesanan"
                    class="w-full px-3.5 py-2.5 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 resize-none focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/30 transition-colors"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-[#3b2230]/10">
                <button type="button" onclick="closeCancelModal()"
                    class="px-4 py-2.5 text-sm font-semibold text-[#3b2230]/70 hover:text-[#3b2230] hover:bg-[#3b2230]/[0.05] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                    Kembali
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-red-700 hover:bg-red-800 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-red-700/60">
                    Batalkan reservasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCancelModal(bookingId) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelBookingForm');
        if (!modal || !form) return;

        form.action = `/bookings/${bookingId}/cancel`;
        const reasonInput = document.getElementById('cancellation_reason');
        if (reasonInput) reasonInput.value = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (reasonInput) reasonInput.focus();
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    window.addEventListener('click', function (e) {
        if (e.target === document.getElementById('cancelModal')) closeCancelModal();
    });

    window.addEventListener('keydown', function (e) {
        const modal = document.getElementById('cancelModal');
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeCancelModal();
    });
</script>