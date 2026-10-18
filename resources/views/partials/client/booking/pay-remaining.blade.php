{{-- partials/client/booking/pay-remaining.blade.php  |  butuh: $b
     Status confirmed + DP terbayar: klien melunasi sisa tagihan. --}}
@php
    $totalPaid = $b->payments->where('status', 'verified')->sum('amount');
    $remaining = $b->total_price - $totalPaid;
@endphp

@if($remaining > 0)
    <div class="p-5 bg-white border border-[#3b2230]/10 rounded-md">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 pb-4 mb-5 border-b border-[#3b2230]/10">
            <div>
                <h5 class="text-lg [font-family:'Fraunces',serif] font-normal">DP telah diverifikasi</h5>
                <p class="mt-1 text-sm text-[#3b2230]/65 max-w-lg">
                    Transfer sisa pelunasan agar kode penyelesaian terbit.
                </p>
            </div>
            <div class="sm:text-right">
                <span class="block text-xs text-[#3b2230]/55">Sisa tagihan</span>
                <span class="block text-2xl [font-family:'Fraunces',serif] leading-tight">Rp {{ number_format($remaining, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('payments.store', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4"
            onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Mengunggah...';">
            @csrf
            <input type="hidden" name="type" value="full">
            <input type="hidden" name="amount" value="{{ $remaining }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="rem-bank-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Bank / e-wallet pengirim</label>
                    <input id="rem-bank-{{ $b->id }}" type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, DANA" required
                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                </div>
                <div>
                    <label for="rem-sender-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Nama pemilik rekening pengirim</label>
                    <input id="rem-sender-{{ $b->id }}" type="text" name="sender_name" placeholder="Nama di bukti transfer" required
                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                </div>
            </div>

            @include('partials.client.booking.proof-upload', [
                'b' => $b,
                'uploadLabel' => 'Upload bukti screenshot pelunasan',
                'submitLabel' => 'Kirim bukti pelunasan',
            ])
        </form>
    </div>
@endif
