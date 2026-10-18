{{-- partials/client/booking/status-badges.blade.php  |  butuh: $b --}}
@if($b->status === 'pending')
    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#f3e6c8] text-[#7a5a14]">Menunggu konfirmasi MUA</span>
@elseif($b->status === 'waiting_payment')
    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#3b2230]/[0.10] text-[#3b2230]">Menunggu pembayaran</span>
@elseif($b->status === 'confirmed')
    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#e5eee6] text-[#2f5a3c]">Jadwal dikonfirmasi</span>
@elseif($b->status === 'completed')
    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#3b2230] text-[#faf6f1]">Selesai</span>
@else
    <span class="px-2.5 py-1 rounded-full text-xs font-medium border border-[#3b2230]/25 text-[#3b2230]/60">Dibatalkan</span>
@endif

@php
    $paymentLabels = [
        'waiting_verification' => 'Verifikasi admin',
        'dp_paid'              => 'DP terbayar',
        'fully_paid'           => 'Lunas',
        'released_to_mua'      => 'Dana masuk MUA',
    ];
@endphp
@if(isset($paymentLabels[$b->payment_status]))
    <span class="px-2.5 py-1 rounded-full text-xs font-medium border border-[#3b2230]/20 text-[#3b2230]/70">{{ $paymentLabels[$b->payment_status] }}</span>
@endif
