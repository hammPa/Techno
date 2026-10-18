<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Reservasi #{{ $booking->id }} - TemuMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,400;9..144,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] [font-family:'DM_Sans',system-ui,sans-serif] antialiased min-h-screen py-6 px-4 sm:px-6 lg:px-10 lg:py-10 print:bg-white print:p-0">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Navigasi atas --}}
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="print:hidden inline-flex items-center gap-2 text-sm text-[#3b2230]/65 hover:text-[#3b2230] transition-colors">
                <span aria-hidden="true">←</span> Kembali ke dashboard
            </a>
            <div class="flex items-center gap-3">
                <span class="text-sm text-[#3b2230]/55 font-mono">Invoice #GM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                <button type="button" onclick="window.print()"
                    class="print:hidden px-3.5 py-2 bg-white border border-[#3b2230]/20 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                    Cetak
                </button>
            </div>
        </div>

        {{-- Pesan --}}
        @if(session('success'))
            <div role="status" class="px-4 py-3 border-l-2 border-[#4d7a5a] bg-[#e5eee6] text-sm text-[#2f5a3c]">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div role="alert" class="px-4 py-3 border-l-2 border-[#a23b3b] bg-[#f4e3df] text-sm text-[#7a2a2a]">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Header + tracker status --}}
        <header class="p-6 sm:p-8 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-6 border-b border-[#3b2230]/10">
                <div>
                    <span class="block text-sm text-[#3b2230]/55">Detail reservasi makeup</span>
                    <h1 class="mt-1 text-3xl lg:text-4xl leading-tight [font-family:'Fraunces',serif] font-normal">{{ $booking->service->title }}</h1>
                    <p class="mt-2 text-sm text-[#3b2230]/60">Dipesan pada {{ $booking->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                <div class="shrink-0">
                    @if($booking->status === 'pending')
                        <span class="inline-block px-3.5 py-1.5 rounded-full text-sm font-medium bg-[#f3e6c8] text-[#7a5a14]">Menunggu konfirmasi MUA</span>
                    @elseif($booking->status === 'waiting_payment')
                        <span class="inline-block px-3.5 py-1.5 rounded-full text-sm font-medium bg-[#3b2230]/[0.10] text-[#3b2230]">Menunggu pembayaran</span>
                    @elseif($booking->status === 'confirmed')
                        <span class="inline-block px-3.5 py-1.5 rounded-full text-sm font-medium bg-[#e5eee6] text-[#2f5a3c]">Jadwal fix, siap melayani</span>
                    @elseif($booking->status === 'completed')
                        <span class="inline-block px-3.5 py-1.5 rounded-full text-sm font-medium bg-[#3b2230] text-[#faf6f1]">Pesanan selesai</span>
                    @else
                        <span class="inline-block px-3.5 py-1.5 rounded-full text-sm font-medium border border-[#3b2230]/25 text-[#3b2230]/60">Dibatalkan</span>
                    @endif
                </div>
            </div>

            {{-- Tracker langkah --}}
            @if($booking->status !== 'cancelled')
                @php
                    $stepIndex = match($booking->status) {
                        'pending' => 1,
                        'waiting_payment' => 2,
                        'confirmed' => 3,
                        'completed' => 4,
                        default => 1
                    };
                    $steps = ['Pemesanan', 'Pembayaran', 'Jadwal siap', 'Penyelesaian'];
                @endphp
                <ol class="pt-6 grid grid-cols-4" aria-label="Tahapan reservasi">
                    @foreach($steps as $i => $label)
                        @php $n = $i + 1; @endphp
                        <li class="relative text-center" @if($n === $stepIndex) aria-current="step" @endif>
                            @if($n < count($steps))
                                <span class="absolute top-4 left-1/2 w-full h-px {{ $stepIndex > $n ? 'bg-[#3b2230]' : 'bg-[#3b2230]/15' }}" aria-hidden="true"></span>
                            @endif
                            <span class="relative z-10 w-8 h-8 mx-auto rounded-full flex items-center justify-center text-sm font-medium {{ $stepIndex >= $n ? 'bg-[#3b2230] text-[#faf6f1]' : 'bg-[#e9e1d8] text-[#3b2230]/45' }}">{{ $n }}</span>
                            <span class="block mt-2 text-xs sm:text-sm {{ $stepIndex >= $n ? 'font-medium' : 'text-[#3b2230]/45' }}">{{ $label }}</span>
                        </li>
                    @endforeach
                </ol>
            @endif
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_22rem] gap-6 items-start">

            {{-- Kolom kiri: agenda, kontak, riwayat pembayaran --}}
            <div class="space-y-6 min-w-0">

                {{-- Jadwal & lokasi --}}
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-5">Jadwal &amp; lokasi acara</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-4 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md">
                            <span class="block text-xs text-[#3b2230]/55">Hari &amp; tanggal</span>
                            <span class="block mt-1 text-base font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="p-4 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md">
                            <span class="block text-xs text-[#3b2230]/55">Waktu sesi makeup</span>
                            <span class="block mt-1 text-base font-semibold">Pukul {{ date('H:i', strtotime($booking->booking_time)) }} WIB</span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <span class="block text-xs text-[#3b2230]/55">Alamat lengkap</span>
                        <p class="mt-1 text-sm leading-relaxed">{{ $booking->location_address }}</p>
                    </div>

                    @if($booking->notes)
                        <div class="mt-5 px-4 py-3 border-l-2 border-[#3b2230]/40 bg-[#3b2230]/[0.05] text-sm">
                            <span class="font-semibold">Catatan pemesan:</span> <span class="italic">“{{ $booking->notes }}”</span>
                        </div>
                    @endif
                </section>

                {{-- Pihak terkait --}}
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-5">Kontak pihak terkait</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-4 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md text-sm">
                            <span class="block text-xs text-[#3b2230]/55">Klien (pemesan)</span>
                            <p class="mt-1 text-base font-semibold">{{ $booking->client->name }}</p>
                            <p class="mt-1 text-[#3b2230]/70 break-all">{{ $booking->client->email }}</p>
                            @if($booking->client->phone)
                                <p class="mt-1 text-[#3b2230]/70">
                                    WhatsApp:
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->client->phone) }}" target="_blank" rel="noopener"
                                        class="font-medium text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230]">{{ $booking->client->phone }}</a>
                                </p>
                            @endif
                        </div>

                        <div class="p-4 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md text-sm">
                            <span class="block text-xs text-[#3b2230]/55">Partner MUA</span>
                            <p class="mt-1 text-base font-semibold">{{ $booking->mua->muaProfile->studio_name ?? $booking->mua->name }}</p>
                            <p class="mt-1 text-[#3b2230]/70">Area: {{ $booking->mua->muaProfile->city ?? '-' }}</p>
                            @if($booking->mua->phone)
                                <p class="mt-1 text-[#3b2230]/70">
                                    WhatsApp:
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->mua->phone) }}" target="_blank" rel="noopener"
                                        class="font-medium text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230]">{{ $booking->mua->phone }}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- Riwayat pembayaran --}}
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-2">Riwayat transfer pembayaran</h2>

                    <div>
                        @forelse($booking->payments as $payment)
                            <div class="py-4 border-b border-[#3b2230]/10 last:border-b-0 flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-sm font-semibold uppercase">{{ $payment->payment_type ?? 'Transfer' }} ({{ $payment->bank_name }})</span>
                                        @if($payment->status === 'verified')
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-[#e5eee6] text-[#2f5a3c]">Terverifikasi</span>
                                        @elseif($payment->status === 'waiting_verification')
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-[#f3e6c8] text-[#7a5a14]">Verifikasi admin</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium border border-[#3b2230]/25 text-[#3b2230]/60">Ditolak</span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-xs text-[#3b2230]/55">a.n. {{ $payment->sender_name }} · {{ $payment->created_at->format('d-m-Y H:i') }}</p>
                                </div>
                                <span class="shrink-0 text-lg [font-family:'Fraunces',serif]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="py-8 text-center text-sm text-[#3b2230]/60">Belum ada catatan transaksi pembayaran.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Kolom kanan: tagihan + panel tindakan --}}
            <div class="space-y-6 lg:sticky lg:top-6">

                {{-- Rincian tagihan --}}
                <section class="p-6 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-5">Rincian pembayaran</h2>
                    @php
                        $totalVerifiedPaid = $booking->payments->where('status', 'verified')->sum('amount');
                        $remainingBill = max(0, $booking->total_price - $totalVerifiedPaid);
                    @endphp
                    <dl class="space-y-2.5 text-sm pb-4 border-b border-[#3b2230]/10">
                        <div class="flex justify-between gap-3">
                            <dt class="text-[#3b2230]/65">Harga layanan</dt>
                            <dd class="font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-[#3b2230]/65">Total masuk / diverifikasi</dt>
                            <dd class="font-medium text-[#2f5a3c]">- Rp {{ number_format($totalVerifiedPaid, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-[#3b2230]/65">Status bayar</dt>
                            <dd class="font-medium capitalize">{{ str_replace('_', ' ', $booking->payment_status) }}</dd>
                        </div>
                    </dl>
                    <div class="pt-4 flex items-end justify-between gap-3">
                        <span class="text-sm font-medium">Sisa tagihan</span>
                        <span class="text-3xl [font-family:'Fraunces',serif] leading-none">Rp {{ number_format($remainingBill, 0, ',', '.') }}</span>
                    </div>
                </section>

                {{-- Panel tindakan (semua aksi MUA dan klien ada di sini, tanpa partial tambahan) --}}
                @php
                    $isMua = auth()->user()->role === 'mua';

                    // Aksi MUA: hanya status yang punya tindakan
                    $muaPanel = in_array($booking->status, ['pending', 'waiting_payment', 'confirmed', 'completed']) ? $booking->status : null;

                    // Aksi klien
                    $lastRejectedPayment = $booking->payments->where('status', 'rejected')->sortByDesc('created_at')->first();
                    $showRejected = $lastRejectedPayment
                        && in_array($booking->status, ['waiting_payment', 'confirmed'])
                        && $booking->payment_status !== 'fully_paid';

                    $clientPanel = null;
                    if ($booking->status === 'confirmed' && ($booking->payment_status === 'fully_paid' || $booking->completion_code)) {
                        $clientPanel = 'code';
                    } elseif ($booking->status === 'confirmed' && $booking->payment_status === 'dp_paid') {
                        $clientPanel = $remainingBill > 0 ? 'remaining' : null;
                    } elseif ($booking->status === 'waiting_payment' && $booking->payment_status === 'unpaid') {
                        $clientPanel = 'initial';
                    } elseif ($booking->payment_status === 'waiting_verification') {
                        $clientPanel = 'verifying';
                    } elseif ($booking->status === 'completed') {
                        $clientPanel = 'completed';
                    }

                    $canClientCancel = !$isMua
                        && in_array($booking->status, ['pending', 'waiting_payment'])
                        && $booking->payment_status === 'unpaid';

                    $hasAction = $isMua ? $muaPanel !== null : ($showRejected || $clientPanel !== null || $canClientCancel);
                @endphp

                <section class="print:hidden p-6 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-5">Panel tindakan</h2>

                    <div class="space-y-4">
                        @if($isMua)

                            {{-- ===================== AKSI MUA ===================== --}}
                            @if($muaPanel === 'pending')
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="waiting_payment">
                                        <button type="submit" class="px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-50 disabled:cursor-not-allowed text-[#faf6f1] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">Terima jadwal</button>
                                    </form>
                                    <button type="button" onclick="openCancelModal('{{ $booking->id }}')" class="px-4 py-2.5 bg-white border border-[#3b2230]/25 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">Tolak</button>
                                </div>

                            @elseif($muaPanel === 'waiting_payment')
                                <p class="text-sm text-[#3b2230]/65">Menunggu pembayaran klien.</p>
                                {{-- Jika klien tak kunjung bayar, MUA bisa membatalkan pesanan unpaid --}}
                                @if($booking->payment_status === 'unpaid')
                                    <button type="button" onclick="openCancelModal('{{ $booking->id }}')" class="px-4 py-2.5 bg-white border border-[#3b2230]/25 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">Batalkan</button>
                                @endif

                            @elseif($muaPanel === 'confirmed')
                                {{-- Validasi kode 4 digit dari klien --}}
                                <form action="{{ route('bookings.complete', $booking->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label for="completion-code" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Kode 4 digit dari klien</label>
                                        <input id="completion-code" type="text" name="completion_code" maxlength="4" inputmode="numeric" placeholder="0000" required
                                            class="w-full px-3 py-2.5 text-center font-mono font-semibold tracking-[0.4em] text-lg bg-white border border-[#3b2230]/25 rounded-md placeholder:text-[#3b2230]/25 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    </div>
                                    <button type="submit" class="w-full px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-50 disabled:cursor-not-allowed text-[#faf6f1] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">Selesaikan job</button>
                                </form>

                            @elseif($muaPanel === 'completed')
                                <p class="text-sm font-medium text-[#2f5a3c]">Job selesai dan terverifikasi.</p>
                            @endif

                        @else

                            {{-- ===================== AKSI KLIEN ===================== --}}
                            @if($showRejected)
                                <div class="px-4 py-3.5 border-l-2 border-[#3b2230]/60 bg-[#3b2230]/[0.06] text-sm">
                                    <strong class="block font-semibold">Bukti transfer sebelumnya ditolak admin</strong>
                                    <p class="mt-1 italic text-[#3b2230]/80">“{{ $lastRejectedPayment->admin_notes }}”</p>
                                    <p class="mt-1.5 text-xs text-[#3b2230]/65">Silakan cek rekening dan kirimkan kembali bukti transfer yang valid melalui form di bawah ini.</p>
                                </div>
                            @endif

                            @if($clientPanel === 'code')
                                {{-- Kode penyelesaian --}}
                                <div class="p-5 bg-[#3b2230] text-[#faf6f1] rounded-md">
                                    <h3 class="text-xl [font-family:'Fraunces',serif] font-normal">Kode penyelesaian</h3>
                                    <p class="mt-1.5 text-sm text-[#faf6f1]/75 leading-relaxed">
                                        Tagihan telah lunas. Berikan kode 4 digit ini ke MUA <strong class="font-semibold text-[#faf6f1]">hanya setelah sesi makeup selesai</strong>.
                                    </p>
                                    <div class="mt-4 px-5 py-3 bg-[#faf6f1] text-[#3b2230] rounded-md text-center">
                                        <span class="block pl-[0.3em] text-3xl font-mono font-semibold tracking-[0.3em]">{{ $booking->completion_code }}</span>
                                    </div>
                                </div>

                            @elseif($clientPanel === 'remaining')
                                {{-- Pelunasan setelah DP --}}
                                <div>
                                    <h3 class="text-lg [font-family:'Fraunces',serif] font-normal">DP telah diverifikasi</h3>
                                    <p class="mt-1 text-sm text-[#3b2230]/65">Transfer sisa pelunasan sebesar <strong class="font-semibold text-[#3b2230]">Rp {{ number_format($remainingBill, 0, ',', '.') }}</strong> agar kode penyelesaian terbit.</p>
                                </div>
                                <form action="{{ route('payments.store', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4"
                                    onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Mengunggah...';">
                                    @csrf
                                    <input type="hidden" name="type" value="full">
                                    <input type="hidden" name="amount" value="{{ $remainingBill }}">

                                    <div>
                                        <label for="rem-bank" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Bank / e-wallet pengirim</label>
                                        <input id="rem-bank" type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, DANA" required class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    </div>
                                    <div>
                                        <label for="rem-sender" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Nama pemilik rekening pengirim</label>
                                        <input id="rem-sender" type="text" name="sender_name" placeholder="Nama di bukti transfer" required class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    </div>
                                    <div>
                                        <label for="rem-proof" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Upload bukti screenshot pelunasan</label>
                                        <input id="rem-proof" type="file" name="proof_image" accept="image/*" required class="w-full text-sm text-[#3b2230]/65 file:mr-3 file:px-3.5 file:py-2 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#3b2230] file:text-[#faf6f1] hover:file:bg-[#2a1620] file:cursor-pointer">
                                    </div>
                                    <button type="submit" class="w-full px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-50 disabled:cursor-not-allowed text-[#faf6f1] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">Kirim bukti pelunasan</button>
                                </form>

                            @elseif($clientPanel === 'initial')
                                {{-- Pembayaran awal: batas waktu, rekening, form --}}
                                @if($booking->payment_deadline)
                                    <div class="px-4 py-3 bg-[#3b2230] text-[#faf6f1] rounded-md flex items-center justify-between gap-3">
                                        <div>
                                            <span class="block text-xs text-[#faf6f1]/70">Batas waktu pembayaran</span>
                                            <span class="block text-sm font-semibold">{{ $booking->payment_deadline->translatedFormat('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="block text-xs text-[#faf6f1]/70">Sisa waktu</span>
                                            <span class="block text-sm font-semibold">{{ $booking->payment_deadline->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="p-4 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md">
                                    <h3 class="text-sm font-semibold">Rekening resmi platform TemuMUA</h3>
                                    <ul class="mt-2 space-y-1 text-sm text-[#3b2230]/75">
                                        <li><strong class="font-semibold text-[#3b2230]">BCA:</strong> 8735-0921-12 (a/n TemuMUA Indonesia)</li>
                                        <li><strong class="font-semibold text-[#3b2230]">DANA / GoPay:</strong> 0812-3456-7890 (a/n Admin TemuMUA)</li>
                                    </ul>
                                    <p class="mt-2 text-xs text-[#3b2230]/55">Pilih bayar lunas (full) atau DP 50% untuk booking jadwal.</p>
                                </div>

                                <form action="{{ route('payments.store', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4"
                                    onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Mengunggah...';">
                                    @csrf
                                    <div>
                                        <label for="pay-type" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Jenis pembayaran</label>
                                        <select id="pay-type" name="type" required
                                            class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                            <option value="full">Lunas (full) - Rp {{ number_format($booking->total_price, 0, ',', '.') }}</option>
                                            <option value="dp">DP 50% - Rp {{ number_format($booking->total_price * 0.5, 0, ',', '.') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pay-bank" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Metode / bank</label>
                                        <input id="pay-bank" type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, DANA" required class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    </div>
                                    <div>
                                        <label for="pay-sender" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Nama pemilik rekening</label>
                                        <input id="pay-sender" type="text" name="sender_name" placeholder="Nama di bukti transfer" required class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    </div>
                                    <div>
                                        <label for="pay-amount" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Nominal ditransfer (Rp)</label>
                                        <input id="pay-amount" type="number" name="amount" min="10000" placeholder="Contoh: 200000" required class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    </div>
                                    <div>
                                        <label for="pay-proof" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Upload bukti screenshot</label>
                                        <input id="pay-proof" type="file" name="proof_image" accept="image/*" required class="w-full text-sm text-[#3b2230]/65 file:mr-3 file:px-3.5 file:py-2 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#3b2230] file:text-[#faf6f1] hover:file:bg-[#2a1620] file:cursor-pointer">
                                    </div>
                                    <button type="submit" class="w-full px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-50 disabled:cursor-not-allowed text-[#faf6f1] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">Kirim bukti pembayaran</button>
                                </form>

                            @elseif($clientPanel === 'verifying')
                                <div class="px-4 py-3.5 border-l-2 border-[#7a5a14]/50 bg-[#f3e6c8]/60 text-sm text-[#7a5a14]">
                                    <h3 class="font-semibold">Bukti transfer sedang diverifikasi</h3>
                                    <p class="mt-0.5 text-xs">Admin TemuMUA sedang memeriksa mutasi pembayaran Anda. Status akan diperbarui segera setelah diverifikasi.</p>
                                </div>

                            @elseif($clientPanel === 'completed')
                                <p class="text-sm font-medium">Layanan selesai dilaksanakan. Terima kasih telah menggunakan TemuMUA!</p>

                                @if(!$booking->review)
                                    <button type="button"
                                        onclick="openReviewModal(@js((string) $booking->id), @js($booking->mua->muaProfile->studio_name ?? $booking->mua->name), @js($booking->service->title))"
                                        class="w-full px-4 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-50 disabled:cursor-not-allowed text-[#faf6f1] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">
                                        Beri ulasan MUA
                                    </button>
                                @else
                                    <div class="pt-4 border-t border-[#3b2230]/10">
                                        <div class="flex items-center gap-1 text-sm" aria-label="Rating {{ $booking->review->rating }} dari 5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $booking->review->rating ? '' : 'text-[#3b2230]/25' }}">★</span>
                                            @endfor
                                            <span class="ml-1.5 text-xs text-[#3b2230]/65">{{ $booking->review->rating }}.0 / 5.0</span>
                                        </div>
                                        @if($booking->review->comment)
                                            <p class="mt-1.5 text-sm italic text-[#3b2230]/80">“{{ $booking->review->comment }}”</p>
                                        @endif
                                        <span class="mt-1.5 block text-xs text-[#3b2230]/50">Diulas pada {{ $booking->review->created_at->format('d-m-Y') }}</span>
                                    </div>
                                @endif
                            @endif

                            @if($canClientCancel)
                                <button type="button" onclick="openCancelModal('{{ $booking->id }}')" class="w-full px-4 py-2.5 bg-white border border-[#3b2230]/25 hover:border-[#3b2230] rounded-md text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">Batalkan pesanan</button>
                            @endif

                        @endif

                        @unless($hasAction)
                            <p class="text-sm text-[#3b2230]/60">Tidak ada tindakan yang perlu dilakukan saat ini.</p>
                        @endunless
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('partials.modal-cancel-booking')
    @include('partials.modal-review')
</body>
</html>