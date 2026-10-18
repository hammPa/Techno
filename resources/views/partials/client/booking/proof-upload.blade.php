{{-- partials/client/booking/proof-upload.blade.php  |  butuh: $b, $uploadLabel, $submitLabel
     Bagian bawah form pembayaran: input bukti transfer + tombol kirim. Dipakai di dalam <form>. --}}
<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div class="flex-1 min-w-0">
        <label for="proof-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">{{ $uploadLabel }}</label>
        <input id="proof-{{ $b->id }}" type="file" name="proof_image" accept="image/*" required
            class="w-full text-sm text-[#3b2230]/65 file:mr-3 file:px-3.5 file:py-2 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#3b2230] file:text-[#faf6f1] hover:file:bg-[#2a1620] file:cursor-pointer">
    </div>
    <button type="submit"
        class="px-5 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-50 disabled:cursor-not-allowed text-[#faf6f1] rounded-md text-sm font-medium whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">
        {{ $submitLabel }}
    </button>
</div>
