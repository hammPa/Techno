{{-- partials/mua/reservations.blade.php --}}
<section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">

    <!-- Judul + filter -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal leading-tight">Daftar reservasi masuk dan agenda</h2>
            <p class="mt-1.5 text-sm text-[#3b2230]/60">
                Konfirmasi jadwal dan verifikasi kode penyelesaian setelah merias.
                <span class="font-medium text-[#3b2230]">{{ $bookings->where('status', 'pending')->count() }} menunggu jawaban.</span>
            </p>
        </div>

        <div class="shrink-0">
            <label for="filter-reservasi" class="sr-only">Filter status reservasi</label>
            <select id="filter-reservasi"
                class="w-full sm:w-56 px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                <option value="all">Filter: semua status</option>
                <option value="pending">Permintaan baru</option>
                <option value="waiting_payment">Menunggu bayar klien</option>
                <option value="confirmed">Jadwal fix</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
    </div>

    <!-- Daftar kartu -->
    <div class="space-y-4">
        @forelse($bookings as $bk)
            @include('partials.mua.single-reservation-card', ['bk' => $bk])
        @empty
            <p class="py-12 text-center text-sm text-[#3b2230]/60 border border-dashed border-[#3b2230]/20 rounded-md">
                Belum ada pesanan riasan yang masuk.
            </p>
        @endforelse

        <p id="reservasi-filter-empty" class="hidden py-12 text-center text-sm text-[#3b2230]/60 border border-dashed border-[#3b2230]/20 rounded-md">
            Tidak ada reservasi dengan status ini.
        </p>
    </div>
</section>

<script>
    (function () {
        var select = document.getElementById('filter-reservasi');
        var empty = document.getElementById('reservasi-filter-empty');
        if (!select) return;

        select.addEventListener('change', function () {
            var value = select.value;
            var items = document.querySelectorAll('[data-booking-status]');
            var shown = 0;

            items.forEach(function (el) {
                var match = value === 'all' || el.dataset.bookingStatus === value;
                el.classList.toggle('hidden', !match);
                if (match) shown++;
            });

            if (empty) empty.classList.toggle('hidden', shown !== 0 || items.length === 0);
        });
    })();
</script>