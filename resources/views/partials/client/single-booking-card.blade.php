<div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/60">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <h3 class="font-bold text-sm text-slate-800">{{ $b->service->title }}</h3>

                @if($b->status === 'pending')
                    <span class="text-[10px] px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full font-bold">Menunggu Konfirmasi MUA</span>
                @elseif($b->status === 'waiting_payment')
                    <span class="text-[10px] px-2.5 py-0.5 bg-rose-100 text-rose-700 rounded-full font-bold animate-pulse">Menunggu Pembayaran</span>
                @elseif($b->status === 'confirmed')
                    <span class="text-[10px] px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-bold">Jadwal Dikonfirmasi</span>
                @elseif($b->status === 'completed')
                    <span class="text-[10px] px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full font-bold">Selesai</span>
                @else
                    <span class="text-[10px] px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full font-bold">Dibatalkan</span>
                @endif

                @if($b->payment_status === 'waiting_verification')
                    <span class="text-[10px] px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full font-semibold">Verifikasi Admin</span>
                @elseif($b->payment_status === 'dp_paid')
                    <span class="text-[10px] px-2 py-0.5 bg-teal-100 text-teal-800 rounded-full font-semibold">DP Terbayar</span>
                @elseif($b->payment_status === 'fully_paid')
                    <span class="text-[10px] px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-semibold">Lunas</span>
                @elseif($b->payment_status === 'released_to_mua')
                    <span class="text-[10px] px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full font-semibold">Dana Masuk MUA</span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">MUA: <strong class="text-slate-700">{{ $b->mua->muaProfile->studio_name ?? $b->mua->name }}</strong></p>
            <p class="text-xs text-slate-600 mt-0.5">📅 {{ date('d M Y', strtotime($b->booking_date)) }} • Pukul {{ date('H:i', strtotime($b->booking_time)) }} WIB</p>
            <p class="text-[11px] text-slate-400 mt-1">📍 {{ $b->location_address }}</p>
            @if($b->notes)
                <p class="text-[11px] text-slate-400 italic mt-0.5">Catatan: "{{ $b->notes }}"</p>
            @endif

            @if($b->status === 'cancelled' && $b->cancellation_reason)
                <div class="mt-2 text-[11px] text-rose-700 bg-rose-50 border border-rose-200/70 px-3 py-1.5 rounded-xl inline-block">
                    <strong>Alasan Batal:</strong> {{ $b->cancellation_reason }}
                </div>
            @endif
        </div>

        <div class="flex flex-col sm:items-end justify-between gap-2">
            <div class="text-left sm:text-right">
                <span class="text-[10px] uppercase font-semibold text-slate-400 block">Total Biaya</span>
                <span class="text-base sm:text-lg font-extrabold text-rose-600">
                    Rp {{ number_format($b->total_price, 0, ',', '.') }}
                </span>
            </div>

            @if(in_array($b->status, ['pending', 'waiting_payment']) && $b->payment_status === 'unpaid')
                <button type="button" 
                    onclick="openCancelModal('{{ $b->id }}')" 
                    class="text-xs font-semibold px-3 py-1.5 bg-white border border-rose-300 text-rose-600 hover:bg-rose-50 rounded-xl transition shadow-2xs self-start sm:self-auto">
                    ✕ Batalkan Pesanan
                </button>
            @endif
        </div>
    </div>

    <!-- Panel Aksi: Kode 4 Digit / Form Upload Pembayaran / Pelunasan -->
    <div class="mt-4">
        @php
            $lastRejectedPayment = $b->payments()->where('status', 'rejected')->latest()->first();
        @endphp

        @if($lastRejectedPayment && in_array($b->status, ['waiting_payment', 'confirmed']) && $b->payment_status !== 'fully_paid')
            <div class="p-3.5 mb-3 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-2.5 text-rose-800 text-xs shadow-xs">
                <span class="text-base">⚠️</span>
                <div>
                    <strong class="font-bold block">Bukti transfer Anda sebelumnya ditolak Admin:</strong>
                    <p class="mt-0.5 text-rose-700 italic">"{{ $lastRejectedPayment->admin_notes }}"</p>
                    <p class="mt-1 text-[11px] text-rose-600 font-medium">Silakan cek rekening dan kirimkan kembali bukti transfer yang valid melalui form di bawah ini.</p>
                </div>
            </div>
        @endif

        @if($b->status === 'confirmed' && ($b->payment_status === 'fully_paid' || $b->completion_code))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
                <div class="text-center sm:text-left">
                    <div class="flex items-center gap-1.5 justify-center sm:justify-start">
                        <span class="text-base">🔐</span>
                        <h4 class="text-xs font-bold text-emerald-900">Kode Penyelesaian Reservasi</h4>
                    </div>
                    <p class="text-[11px] text-emerald-700 mt-0.5">
                        Tagihan telah lunas! Berikan kode 4 digit ini ke MUA <strong>hanya setelah sesi makeup selesai</strong>.
                    </p>
                </div>
                <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-emerald-300 shadow-xs">
                    <span class="text-xl font-black tracking-widest text-emerald-600 font-mono">
                        {{ $b->completion_code }}
                    </span>
                </div>
            </div>

        @elseif($b->status === 'confirmed' && $b->payment_status === 'dp_paid')
            @php
                $totalPaid = $b->payments()->where('status', 'verified')->sum('amount');
                $remaining = $b->total_price - $totalPaid;
            @endphp

            @if($remaining > 0)
                <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-4 shadow-xs">
                    <div class="flex items-center justify-between mb-3 border-b border-amber-200/60 pb-2">
                        <div>
                            <h5 class="text-xs font-bold text-amber-900">Status: DP Telah Diverifikasi</h5>
                            <p class="text-[11px] text-amber-700">Silakan transfer sisa pelunasan sebesar <strong>Rp {{ number_format($remaining, 0, ',', '.') }}</strong> agar kode verifikasi penyelesaian terbit.</p>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 bg-amber-200 text-amber-900 rounded-full">Sisa Tagihan</span>
                    </div>

                    <form action="{{ route('payments.store', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3"
                        onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Mengunggah...';">
                        @csrf
                        <input type="hidden" name="type" value="full">
                        <input type="hidden" name="amount" value="{{ $remaining }}">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bank / E-Wallet Pengirim</label>
                                <input type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, DANA" required
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:border-rose-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Pemilik Rekening Pengirim</label>
                                <input type="text" name="sender_name" placeholder="Nama di bukti transfer" required
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:border-rose-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-1">
                            <div class="flex-1">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Upload Bukti Screenshot Pelunasan</label>
                                <input type="file" name="proof_image" accept="image/*" required
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-rose-600 transition">
                            </div>
                            <div class="sm:self-end">
                                <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                    Kirim Bukti Pelunasan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

        @elseif($b->status === 'waiting_payment' && $b->payment_status === 'unpaid')
            <div class="bg-white border border-rose-200 rounded-2xl p-4 shadow-xs">
                <div class="mb-3 p-3 bg-rose-50/70 border border-rose-100 rounded-xl">
                    <h5 class="text-xs font-bold text-rose-900 mb-1">💳 Rekening Resmi Platform GlowMUA:</h5>
                    <div class="text-xs text-slate-600 space-y-0.5">
                        <p>• <strong>BCA:</strong> 8735-0921-12 (a/n GlowMUA Indonesia)</p>
                        <p>• <strong>DANA / GoPay:</strong> 0812-3456-7890 (a/n Admin GlowMUA)</p>
                    </div>
                    <p class="text-[10px] text-rose-500 mt-1.5">* Pilih bayar Lunas (Full) atau DP 50% untuk booking jadwal.</p>
                </div>

                <form action="{{ route('payments.store', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3"
                    onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Mengunggah...';">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis Pembayaran</label>
                            <select name="type" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:border-rose-500 focus:outline-none">
                                <option value="full">Lunas (Full) - Rp {{ number_format($b->total_price, 0, ',', '.') }}</option>
                                <option value="dp">DP 50% - Rp {{ number_format($b->total_price * 0.5, 0, ',', '.') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Metode / Bank</label>
                            <input type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, DANA" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:border-rose-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Pemilik Rekening</label>
                            <input type="text" name="sender_name" placeholder="Nama di bukti transfer" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:border-rose-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nominal Ditransfer (Rp)</label>
                            <input type="number" name="amount" min="10000" placeholder="Contoh: 200000" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:border-rose-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-1">
                        <div class="flex-1">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Upload Bukti Screenshot</label>
                            <input type="file" name="proof_image" accept="image/*" required
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-rose-600 transition">
                        </div>
                        <div class="sm:self-end">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                Kirim Bukti Pembayaran
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        @elseif($b->payment_status === 'waiting_verification')
            <div class="bg-amber-50 border border-amber-200 p-3.5 rounded-2xl flex items-center gap-3">
                <span class="text-xl">⏳</span>
                <div>
                    <h5 class="text-xs font-bold text-amber-900">Bukti Transfer Sedang Diverifikasi</h5>
                    <p class="text-[11px] text-amber-700 mt-0.5">Admin GlowMUA sedang memeriksa mutasi pembayaran Anda. Status akan diperbarui segera setelah diverifikasi.</p>
                </div>
            </div>

        @elseif($b->status === 'completed')
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-base">🎉</span>
                        <span class="text-xs font-semibold text-blue-900">Layanan selesai dilaksanakan. Terima kasih telah menggunakan GlowMUA!</span>
                    </div>

                    @if(!$b->review)
                        <button type="button" 
                            onclick="openReviewModal('{{ $b->id }}', '{{ $b->mua->muaProfile->studio_name ?? $b->mua->name }}', '{{ $b->service->title }}')"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition shadow-xs whitespace-nowrap self-start sm:self-auto">
                            ⭐ Beri Ulasan MUA
                        </button>
                    @endif
                </div>

                @if($b->review)
                    <div class="mt-3 pt-3 border-t border-blue-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <div class="flex items-center gap-1 text-amber-500 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $b->review->rating ? '★' : '☆' }}</span>
                                @endfor
                                <span class="text-xs font-bold text-slate-700 ml-1.5">{{ $b->review->rating }}.0 / 5.0</span>
                            </div>
                            @if($b->review->comment)
                                <p class="text-[11px] text-slate-600 italic mt-1">"{{ $b->review->comment }}"</p>
                            @endif
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium">Diulas pada {{ $b->review->created_at->format('d M Y') }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>