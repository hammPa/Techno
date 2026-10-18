<div data-booking-status="{{ $bk->status }}" class="p-5 sm:p-6 bg-[#faf6f1] border border-[#3b2230]/10 rounded-lg">

    <!-- Jenis makeup + status job -->
    <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
        <h3 class="text-xl [font-family:'Fraunces',serif] font-normal leading-tight">{{ $bk->service->title }}</h3>

        @if($bk->status === 'pending')
            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#f3e6c8] text-[#7a5a14]">Permintaan baru</span>
        @elseif($bk->status === 'waiting_payment')
            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#3b2230]/[0.10] text-[#3b2230]">Menunggu bayar klien</span>
        @elseif($bk->status === 'confirmed')
            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#e5eee6] text-[#2f5a3c]">Jadwal fix, siap melayani</span>
        @elseif($bk->status === 'completed')
            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#3b2230] text-[#faf6f1]">Selesai, dana cair</span>
        @else
            <span class="px-2.5 py-1 rounded-full text-xs font-medium border border-[#3b2230]/25 text-[#3b2230]/60">Dibatalkan</span>
        @endif
    </div>

    <a href="{{ route('bookings.show', $bk->id) }}"
        class="inline-block mt-3 px-3 py-1.5 bg-white border border-[#3b2230]/20 rounded-md text-xs font-medium hover:border-[#3b2230] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
        Lihat detail pesanan
    </a>

    <!-- Data pesanan -->
    <dl class="mt-5 grid grid-cols-1 sm:grid-cols-[auto_1fr] gap-x-6 gap-y-2 text-sm">
        <dt class="text-[#3b2230]/55">Klien</dt>
        <dd>
            <span class="font-medium">{{ $bk->client->name }}</span>
            @if($bk->client->phone)
                <span class="text-[#3b2230]/55"> · WA</span>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bk->client->phone) }}" target="_blank" rel="noopener"
                    class="underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230]">{{ $bk->client->phone }}</a>
            @endif
        </dd>

        <dt class="text-[#3b2230]/55">Tanggal pemesanan</dt>
        <dd>{{ $bk->created_at->format('d-m-Y') }}</dd>

        <dt class="text-[#3b2230]/55">Tanggal booking</dt>
        <dd>{{ \Carbon\Carbon::parse($bk->booking_date)->format('d-m-Y') }}, pukul {{ date('H:i', strtotime($bk->booking_time)) }} WIB</dd>

        <dt class="text-[#3b2230]/55">Alamat</dt>
        <dd>{{ $bk->location_address }}</dd>

        @if($bk->notes)
            <dt class="text-[#3b2230]/55">Catatan</dt>
            <dd class="italic text-[#3b2230]/75">“{{ $bk->notes }}”</dd>
        @endif
    </dl>

    {{-- Alasan jika dibatalkan --}}
    @if($bk->status === 'cancelled' && $bk->cancellation_reason)
        <div class="mt-4 px-4 py-3 border-l-2 border-[#3b2230]/50 bg-[#3b2230]/[0.06] text-sm text-[#3b2230]">
            <span class="font-semibold">Alasan batal:</span> {{ $bk->cancellation_reason }}
        </div>
    @endif

    <!-- Total biaya + aksi -->
    <div class="mt-5 pt-5 border-t border-[#3b2230]/10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <span class="block text-xs text-[#3b2230]/55">Total biaya</span>
            <span class="block text-2xl [font-family:'Fraunces',serif] leading-tight">Rp {{ number_format($bk->total_price, 0, ',', '.') }}</span>
            <span class="block mt-1 text-xs text-[#3b2230]/55">Pembayaran: {{ strtolower(str_replace('_', ' ', $bk->payment_status)) }}</span>
        </div>

        {{-- Aksi MUA berdasarkan status --}}
        @if($bk->status === 'pending')
            <div class="flex items-center gap-2">
                <form action="{{ route('bookings.updateStatus', $bk->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="waiting_payment">
                    <button type="submit"
                        class="px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] text-[#faf6f1] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-[#faf6f1] focus-visible:ring-[#3b2230]">
                        Terima jadwal
                    </button>
                </form>
                <button type="button" onclick="openCancelModal('{{ $bk->id }}')"
                    class="px-4 py-2.5 bg-white border border-[#3b2230]/25 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                    Tolak
                </button>
            </div>

        @elseif($bk->status === 'waiting_payment')
            <div class="flex items-center gap-3">
                <span class="text-sm text-[#3b2230]/65">Menunggu pembayaran klien</span>
                {{-- Jika klien tak kunjung bayar, MUA bisa membatalkan pesanan unpaid --}}
                @if($bk->payment_status === 'unpaid')
                    <button type="button" onclick="openCancelModal('{{ $bk->id }}')"
                        class="px-4 py-2.5 bg-white border border-[#3b2230]/25 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                        Batalkan
                    </button>
                @endif
            </div>

        @elseif($bk->status === 'confirmed')
            {{-- Validasi kode 4 digit dari klien --}}
            <form action="{{ route('bookings.complete', $bk->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <label for="completion-code-{{ $bk->id }}" class="sr-only">Kode 4 digit dari klien</label>
                <input id="completion-code-{{ $bk->id }}" type="text" name="completion_code" maxlength="4" inputmode="numeric" placeholder="Kode 4 digit" required
                    class="w-32 px-3 py-2.5 text-center font-mono font-semibold tracking-widest text-sm bg-white border border-[#3b2230]/25 rounded-md placeholder:font-sans placeholder:font-normal placeholder:tracking-normal placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                <button type="submit"
                    class="px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] text-[#faf6f1] rounded-md text-sm font-medium whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-[#faf6f1] focus-visible:ring-[#3b2230]">
                    Selesaikan job
                </button>
            </form>

        @elseif($bk->status === 'completed')
            <span class="text-sm font-medium text-[#2f5a3c]">Job selesai dan terverifikasi</span>
        @endif
    </div>
</div>