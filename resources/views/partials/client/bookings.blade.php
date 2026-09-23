<div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
        <div>
            <h2 class="font-bold text-base text-slate-900">Jadwal Reservasi Rias Saya</h2>
            <p class="text-xs text-slate-400">Daftar agenda riasan dan transaksi pembayaran Anda</p>
        </div>
        <span class="text-xs font-bold px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full">
            {{ $myBookings->count() }} Pesanan
        </span>
    </div>

    <div class="space-y-4">
        @forelse($myBookings as $b)
            @include('partials.client.single-booking-card', ['b' => $b])
        @empty
            <div class="text-center py-8 text-slate-400 text-xs">
                Belum ada reservasi aktif. Buka tab <strong>Katalog MUA</strong> untuk mulai memesan jadwal rias.
            </div>
        @endforelse
    </div>
</div>