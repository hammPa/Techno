<div class="p-4 sm:p-5 rounded-2xl bg-slate-50/80 border border-slate-200">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <h4 class="font-bold text-sm text-slate-900">{{ $bk->service->title }}</h4>
                
                {{-- Badge Status Reservasi --}}
                @if($bk->status === 'pending')
                    <span class="text-[10px] px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full font-bold">Permintaan Baru</span>
                @elseif($bk->status === 'waiting_payment')
                    <span class="text-[10px] px-2.5 py-0.5 bg-rose-100 text-rose-700 rounded-full font-bold">Menunggu Bayar Klien</span>
                @elseif($bk->status === 'confirmed')
                    <span class="text-[10px] px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-bold">Jadwal Fix / Siap Melayani</span>
                @elseif($bk->status === 'completed')
                    <span class="text-[10px] px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full font-bold">Selesai & Dana Cair</span>
                @else
                    <span class="text-[10px] px-2.5 py-0.5 bg-red-100 text-red-700 rounded-full font-bold">Dibatalkan</span>
                @endif

                {{-- Badge Status Finansial --}}
                <span class="text-[10px] px-2 py-0.5 bg-slate-200 text-slate-700 rounded-full font-semibold">
                    Bayar: {{ strtoupper(str_replace('_', ' ', $bk->payment_status)) }}
                </span>
            </div>
            <p class="text-xs text-slate-600 mt-1">Klien: <strong>{{ $bk->client->name }}</strong> (WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bk->client->phone) }}" target="_blank" class="text-rose-600 underline">{{ $bk->client->phone }}</a>)</p>
            <p class="text-xs text-slate-500 mt-0.5">📅 {{ date('d M Y', strtotime($bk->booking_date)) }} • ⏰ Pukul {{ date('H:i', strtotime($bk->booking_time)) }} WIB</p>
            <p class="text-[11px] text-slate-500 mt-1">📍 {{ $bk->location_address }}</p>
            @if($bk->notes)
                <p class="text-[11px] text-slate-400 italic mt-0.5">Catatan: "{{ $bk->notes }}"</p>
            @endif

            {{-- Keterangan Alasan jika Dibatalkan --}}
            @if($bk->status === 'cancelled' && $bk->cancellation_reason)
                <div class="mt-2 text-[11px] text-rose-700 bg-rose-50 border border-rose-200/70 px-3 py-1.5 rounded-xl inline-block">
                    <strong>Alasan Batal:</strong> {{ $bk->cancellation_reason }}
                </div>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 border-t lg:border-t-0 pt-3 lg:pt-0 border-slate-200">
            <span class="font-extrabold text-base text-rose-600">Rp {{ number_format($bk->total_price, 0, ',', '.') }}</span>

            {{-- Aksi MUA Berdasarkan Status --}}
            @if($bk->status === 'pending')
                <div class="flex items-center gap-2">
                    <form action="{{ route('bookings.updateStatus', $bk->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="waiting_payment">
                        <button type="submit" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                            Terima Jadwal
                        </button>
                    </form>

                    <button type="button" 
                        onclick="openCancelModal('{{ $bk->id }}')" 
                        class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl text-xs font-semibold transition">
                        Tolak
                    </button>
                </div>

            @elseif($bk->status === 'waiting_payment')
                <div class="flex items-center gap-2">
                    <span class="text-xs text-amber-700 bg-amber-100/70 border border-amber-200 px-3 py-1.5 rounded-xl font-medium">
                        Menunggu Bayar
                    </span>
                    @if($bk->payment_status === 'unpaid')
                        <button type="button" 
                            onclick="openCancelModal('{{ $bk->id }}')" 
                            class="px-3 py-1.5 border border-rose-300 text-rose-600 hover:bg-rose-50 rounded-xl text-xs font-semibold transition">
                            Batalkan
                        </button>
                    @endif
                </div>

            @elseif($bk->status === 'confirmed')
                <form action="{{ route('bookings.complete', $bk->id) }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-2 bg-white p-2 border border-slate-200 rounded-2xl shadow-xs">
                    @csrf
                    <input type="text" name="completion_code" maxlength="4" placeholder="Kode 4-Digit" required
                        class="w-28 text-center font-mono font-bold tracking-widest text-xs px-2 py-1.5 bg-slate-50 border border-slate-300 rounded-xl focus:border-rose-500 focus:outline-none">
                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition whitespace-nowrap">
                        ✓ Selesaikan Job
                    </button>
                </form>

            @elseif($bk->status === 'completed')
                <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-xl font-semibold">
                    ✓ Job Selesai & Terverifikasi
                </span>
            @endif
        </div>
    </div>
</div>