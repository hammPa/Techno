{{-- partials/client/bookings.blade.php --}}
<section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 mb-6">
        <div>
            <h2 class="text-2xl lg:text-3xl [font-family:'Fraunces',serif] font-normal leading-tight">Jadwal reservasi rias saya</h2>
            <p class="mt-1.5 text-sm text-[#3b2230]/60">Daftar agenda riasan dan transaksi pembayaran Anda.</p>
        </div>
        <span class="shrink-0 px-3 py-1 rounded-full bg-[#3b2230]/[0.07] text-sm font-medium">
            {{ $myBookings->count() }} pesanan
        </span>
    </div>

    <div class="space-y-4">
        @forelse($myBookings as $b)
            @include('partials.client.single-booking-card', ['b' => $b])
        @empty
            <div class="py-12 text-center text-sm text-[#3b2230]/60 border border-dashed border-[#3b2230]/20 rounded-md">
                Belum ada reservasi aktif. Buka tab <strong class="font-semibold text-[#3b2230]">Katalog MUA</strong> untuk mulai memesan jadwal rias.
            </div>
        @endforelse
    </div>
</section>