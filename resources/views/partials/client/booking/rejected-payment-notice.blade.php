{{-- partials/client/booking/rejected-payment-notice.blade.php  |  butuh: $payment --}}
<div class="px-4 py-3.5 border-l-2 border-[#3b2230]/60 bg-[#3b2230]/[0.06] text-sm">
    <strong class="block font-semibold">Bukti transfer Anda sebelumnya ditolak admin</strong>
    <p class="mt-1 italic text-[#3b2230]/80">“{{ $payment->admin_notes }}”</p>
    <p class="mt-1.5 text-xs text-[#3b2230]/65">Silakan cek rekening dan kirimkan kembali bukti transfer yang valid melalui form di bawah ini.</p>
</div>
