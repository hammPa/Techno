{{-- partials/client/booking/pay-initial.blade.php  |  butuh: $b
     Status waiting_payment + belum bayar: batas waktu, rekening platform, dan form bukti transfer. --}}
<div class="p-5 bg-white border border-[#3b2230]/10 rounded-md">

    {{-- Batas waktu pembayaran --}}
    @if($b->payment_deadline)
        <div class="mb-5 px-4 py-3 bg-[#3b2230] text-[#faf6f1] rounded-md flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <span class="block text-xs text-[#faf6f1]/70">Batas waktu pembayaran</span>
                <span class="block text-sm font-semibold">{{ $b->payment_deadline->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>
            <div class="sm:text-right">
                <span class="block text-xs text-[#faf6f1]/70">Sisa waktu</span>
                <span class="block text-sm font-semibold">{{ $b->payment_deadline->diffForHumans() }}</span>
            </div>
        </div>
    @endif

    {{-- Rekening resmi --}}
    <div class="mb-5 p-4 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md">
        <h5 class="text-sm font-semibold">Rekening resmi platform TemuMUA</h5>
        <ul class="mt-2 space-y-1 text-sm text-[#3b2230]/75">
            <li><strong class="font-semibold text-[#3b2230]">BCA:</strong> 8735-0921-12 (a/n TemuMUA Indonesia)</li>
            <li><strong class="font-semibold text-[#3b2230]">DANA / GoPay:</strong> 0812-3456-7890 (a/n Admin TemuMUA)</li>
        </ul>
        <p class="mt-2 text-xs text-[#3b2230]/55">Pilih bayar lunas (full) atau DP 50% untuk booking jadwal.</p>
    </div>

    <form action="{{ route('payments.store', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4"
        onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Mengunggah...';">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="pay-type-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Jenis pembayaran</label>
                <select id="pay-type-{{ $b->id }}" name="type" required
                    class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                    <option value="full">Lunas (full) - Rp {{ number_format($b->total_price, 0, ',', '.') }}</option>
                    <option value="dp">DP 50% - Rp {{ number_format($b->total_price * 0.5, 0, ',', '.') }}</option>
                </select>
            </div>
            <div>
                <label for="pay-bank-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Metode / bank</label>
                <input id="pay-bank-{{ $b->id }}" type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, DANA" required
                    class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
            </div>
            <div>
                <label for="pay-sender-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Nama pemilik rekening</label>
                <input id="pay-sender-{{ $b->id }}" type="text" name="sender_name" placeholder="Nama di bukti transfer" required
                    class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
            </div>
            <div>
                <label for="pay-amount-{{ $b->id }}" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Nominal ditransfer (Rp)</label>
                <input id="pay-amount-{{ $b->id }}" type="number" name="amount" min="10000" placeholder="Contoh: 200000" required
                    class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
            </div>
        </div>

        @include('partials.client.booking.proof-upload', [
            'b' => $b,
            'uploadLabel' => 'Upload bukti screenshot',
            'submitLabel' => 'Kirim bukti pembayaran',
        ])
    </form>
</div>
