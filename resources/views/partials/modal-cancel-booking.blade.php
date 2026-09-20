<!-- Modal Konfirmasi Pembatalan Booking -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-slate-100 transition-all">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <span class="p-2 bg-rose-100 text-rose-600 rounded-xl text-sm font-bold">✕</span>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">Batalkan Reservasi</h3>
            </div>
            <button type="button" onclick="closeCancelModal()" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
        </div>

        <form id="cancelBookingForm" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="cancellation_reason" class="block text-xs font-bold text-slate-700 mb-1">
                    Alasan Pembatalan <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="cancellation_reason" 
                    id="cancellation_reason" 
                    rows="3" 
                    required 
                    placeholder="Tulis alasan pembatalan pesanan..." 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-rose-500 focus:bg-white resize-none"></textarea>
                <p class="text-[11px] text-slate-400 mt-1">Alasan pembatalan ini akan dicatat dalam riwayat reservasi.</p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeCancelModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">
                    Konfirmasi Pembatalan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCancelModal(bookingId) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelBookingForm');
        if (modal && form) {
            form.action = `/bookings/${bookingId}/cancel`;
            const reasonInput = document.getElementById('cancellation_reason');
            if (reasonInput) reasonInput.value = '';
            modal.classList.remove('hidden');
        }
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('cancelModal');
        if (e.target === modal) {
            closeCancelModal();
        }
    });
</script>