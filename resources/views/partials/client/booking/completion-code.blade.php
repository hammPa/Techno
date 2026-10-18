{{-- partials/client/booking/completion-code.blade.php  |  butuh: $b --}}
<div class="p-5 sm:p-6 bg-[#3b2230] text-[#faf6f1] rounded-md flex flex-col sm:flex-row sm:items-center justify-between gap-5">
    <div>
        <h4 class="text-xl [font-family:'Fraunces',serif] font-normal">Kode penyelesaian reservasi</h4>
        <p class="mt-1.5 text-sm text-[#faf6f1]/75 max-w-md leading-relaxed">
            Tagihan telah lunas. Berikan kode 4 digit ini ke MUA <strong class="font-semibold text-[#faf6f1]">hanya setelah sesi makeup selesai</strong>.
        </p>
    </div>
    <div class="shrink-0 px-6 py-3 bg-[#faf6f1] text-[#3b2230] rounded-md text-center">
        <span class="block pl-[0.3em] text-3xl font-mono font-semibold tracking-[0.3em]">{{ $b->completion_code }}</span>
    </div>
</div>
