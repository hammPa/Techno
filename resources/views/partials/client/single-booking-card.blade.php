{{--
    partials/client/single-booking-card.blade.php
    Kartu reservasi klien. Dipakai dengan: @include('partials.client.single-booking-card', ['b' => $b])
    Dipecah menjadi potongan kecil di partials/client/booking/*.
    Saran controller: ->with(['mua.muaProfile', 'service', 'payments', 'review']) agar tidak ada query per kartu.
--}}
@php
    $lastRejectedPayment = $b->payments->where('status', 'rejected')->sortByDesc('created_at')->first();
@endphp

<article class="p-5 sm:p-6 bg-[#faf6f1] border border-[#3b2230]/10 rounded-lg">

    <!-- Info reservasi + total -->
    <div class="flex flex-col sm:flex-row justify-between gap-4 pb-5 border-b border-[#3b2230]/10">
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                <h3 class="text-xl [font-family:'Fraunces',serif] font-normal leading-tight">{{ $b->service->title }}</h3>
                @include('partials.client.booking.status-badges', ['b' => $b])
            </div>

            <a href="{{ route('bookings.show', $b->id) }}"
                class="inline-block mt-3 px-3 py-1.5 bg-white border border-[#3b2230]/20 rounded-md text-xs font-medium hover:border-[#3b2230] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                Lihat detail pesanan
            </a>

            <dl class="mt-4 grid grid-cols-1 sm:grid-cols-[auto_1fr] gap-x-6 gap-y-1.5 text-sm">
                <dt class="text-[#3b2230]/55">MUA</dt>
                <dd class="font-medium">{{ $b->mua->muaProfile->studio_name ?? $b->mua->name }}</dd>

                <dt class="text-[#3b2230]/55">Tanggal booking</dt>
                <dd>{{ \Carbon\Carbon::parse($b->booking_date)->format('d-m-Y') }}, pukul {{ date('H:i', strtotime($b->booking_time)) }} WIB</dd>

                <dt class="text-[#3b2230]/55">Alamat</dt>
                <dd>{{ $b->location_address }}</dd>

                @if($b->notes)
                    <dt class="text-[#3b2230]/55">Catatan</dt>
                    <dd class="italic text-[#3b2230]/75">“{{ $b->notes }}”</dd>
                @endif
            </dl>

            @if($b->status === 'cancelled' && $b->cancellation_reason)
                <div class="mt-4 px-4 py-3 border-l-2 border-[#3b2230]/50 bg-[#3b2230]/[0.06] text-sm">
                    <span class="font-semibold">Alasan batal:</span> {{ $b->cancellation_reason }}
                </div>
            @endif
        </div>

        <div class="shrink-0 flex flex-row sm:flex-col items-end sm:items-end justify-between gap-3">
            <div class="sm:text-right">
                <span class="block text-xs text-[#3b2230]/55">Total biaya</span>
                <span class="block text-2xl [font-family:'Fraunces',serif] leading-tight">Rp {{ number_format($b->total_price, 0, ',', '.') }}</span>
            </div>

            @if(in_array($b->status, ['pending', 'waiting_payment']) && $b->payment_status === 'unpaid')
                <button type="button" onclick="openCancelModal('{{ $b->id }}')"
                    class="px-4 py-2 bg-white border border-[#3b2230]/25 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                    Batalkan pesanan
                </button>
            @endif
        </div>
    </div>

    <!-- Panel aksi: hanya satu yang tampil sesuai status -->
    <div class="mt-5 space-y-3">
        @if($lastRejectedPayment && in_array($b->status, ['waiting_payment', 'confirmed']) && $b->payment_status !== 'fully_paid')
            @include('partials.client.booking.rejected-payment-notice', ['payment' => $lastRejectedPayment])
        @endif

        @if($b->status === 'confirmed' && ($b->payment_status === 'fully_paid' || $b->completion_code))
            @include('partials.client.booking.completion-code', ['b' => $b])

        @elseif($b->status === 'confirmed' && $b->payment_status === 'dp_paid')
            @include('partials.client.booking.pay-remaining', ['b' => $b])

        @elseif($b->status === 'waiting_payment' && $b->payment_status === 'unpaid')
            @include('partials.client.booking.pay-initial', ['b' => $b])

        @elseif($b->payment_status === 'waiting_verification')
            @include('partials.client.booking.waiting-verification')

        @elseif($b->status === 'completed')
            @include('partials.client.booking.completed-review', ['b' => $b])
        @endif
    </div>
</article>