<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Klien - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex pb-20 md:pb-0 font-sans">

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-60 bg-white border-r border-rose-100 p-5 space-y-6 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-slate-900">
            <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center text-sm shadow-sm">✨</span>
            <span>Glow<span class="text-rose-600">MUA</span></span>
        </a>

        <div class="px-3 py-2 bg-slate-100 rounded-xl">
            <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider block">Mode Klien</span>
            <span class="text-xs font-semibold text-slate-800 truncate block">{{ $user->name }}</span>
        </div>

        <nav class="flex-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs">
                <span>🛍</span> Marketplace & Reservasi
            </a>
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>🏠</span> Halaman Utama
            </a>
        </nav>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 text-slate-500 hover:text-rose-600 text-xs font-medium rounded-xl hover:bg-rose-50/50 transition">
                🚪 Keluar
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 max-w-5xl mx-auto p-4 sm:p-6 lg:p-8 w-full">
        <!-- Topbar -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Halo, {{ $user->name }} 👋</h1>
                <p class="text-xs text-slate-500">Pantau status reservasi riasan, pembayaran, dan cari MUA favoritmu</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase shadow-sm">
                {{ substr($user->name, 0, 2) }}
            </div>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-xs">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Card Reservasi Saya -->
        <div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Jadwal Reservasi Rias Saya</h2>
                    <p class="text-xs text-slate-400">Daftar agenda riasan dan transaksi pembayaran Anda</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full">
                    {{ $myBookings->count() }} Pesanan
                </span>
            </div>

            <div class="space-y-4">
                @forelse($myBookings as $b)
                    <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/60">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-bold text-sm text-slate-800">{{ $b->service->title }}</h3>
                                    
                                    {{-- Badge Status Booking --}}
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

                                    {{-- Badge Status Pembayaran --}}
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
                            </div>

                            <div class="text-left sm:text-right">
                                <span class="text-[10px] uppercase font-semibold text-slate-400 block">Total Biaya</span>
                                <span class="text-base sm:text-lg font-extrabold text-rose-600">
                                    Rp {{ number_format($b->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Panel Aksi: Kode 4 Digit / Form Upload Pembayaran / Pelunasan -->
                        <div class="mt-4">
                            {{-- Banner Notifikasi Jika Pembayaran Terakhir Ditolak Admin --}}
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

                            {{-- 1. KODE 4 DIGIT MUNCUL JIKA SUDAH LUNAS --}}
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

                            {{-- 2. FORM PELUNASAN JIKA SUDAH DP --}}
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

                            {{-- 3. FORM PEMBAYARAN AWAL (DP / FULL) --}}
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

                            {{-- 4. BUKTI SEDANG DIVERIFIKASI --}}
                            @elseif($b->payment_status === 'waiting_verification')
                                <div class="bg-amber-50 border border-amber-200 p-3.5 rounded-2xl flex items-center gap-3">
                                    <span class="text-xl">⏳</span>
                                    <div>
                                        <h5 class="text-xs font-bold text-amber-900">Bukti Transfer Sedang Diverifikasi</h5>
                                        <p class="text-[11px] text-amber-700 mt-0.5">Admin GlowMUA sedang memeriksa mutasi pembayaran Anda. Status akan diperbarui segera setelah diverifikasi.</p>
                                    </div>
                                </div>

                            {{-- 5. ORDER SELESAI --}}
                            @elseif($b->status === 'completed')
                                <div class="bg-blue-50 border border-blue-200 p-3.5 rounded-2xl flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">🎉</span>
                                        <span class="text-xs font-semibold text-blue-900">Layanan ini telah selesai dilaksanakan. Terima kasih telah menggunakan GlowMUA!</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs">
                        Belum ada reservasi aktif. Pilih MUA di bawah untuk mulai memesan jadwal rias.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Bagian Katalog Marketplace MUA -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-bold text-base text-slate-900">Katalog Pilihan Makeup Artist</h2>
                <p class="text-xs text-slate-400">Pilih MUA dan atur jadwal janji rias langsung</p>
            </div>
            <span class="text-xs font-semibold text-rose-600">{{ $muaList->count() }} Terdaftar</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($muaList as $mua)
                <div class="bg-white rounded-3xl border border-rose-100 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-rose-50 relative overflow-hidden flex items-center justify-center">
                            @if($mua->portfolios->isNotEmpty() && $mua->portfolios->first()->image_url)
                                @php
                                    $firstImg = $mua->portfolios->first()->image_url;
                                    $coverSrc = str_starts_with($firstImg, 'http') ? $firstImg : Storage::url($firstImg);
                                @endphp
                                <img src="{{ $coverSrc }}" alt="{{ $mua->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">🪞</span>
                            @endif
                            <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-700">
                                📍 {{ $mua->muaProfile->city ?? 'Indonesia' }}
                            </span>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-base text-slate-900 truncate">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h3>
                                <span class="text-xs font-bold text-amber-500">★ 5.0</span>
                            </div>
                            <p class="text-xs text-slate-400">Artisan: {{ $mua->name }}</p>
                            <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                {{ $mua->muaProfile->bio ?? 'Tersedia layanan makeup wisuda, bridal, photoshoot, dan pesta.' }}
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @forelse($mua->services->take(2) as $s)
                                    <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-medium">
                                        {{ $s->title }}
                                    </span>
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">Belum ada paket</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Tarif Mulai</span>
                                <span class="text-xs sm:text-sm font-extrabold text-rose-600">
                                    @if($mua->services->isNotEmpty())
                                        Rp {{ number_format($mua->services->min('price'), 0, ',', '.') }}
                                    @else
                                        Hubungi MUA
                                    @endif
                                </span>
                            </div>
                            <a href="{{ route('mua.detail', $mua->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                                Portofolio & Booking →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-rose-100">
                    <p class="text-xs text-slate-400">Belum ada akun MUA terdaftar.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-6 py-2 flex items-center justify-between z-50">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-rose-600">
            <span class="text-base">🛍</span>
            <span class="text-[10px] font-semibold mt-0.5">Marketplace</span>
        </a>
        <a href="{{ route('home') }}" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">🏠</span>
            <span class="text-[10px] font-medium mt-0.5">Beranda</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
                <span class="text-base">🚪</span>
                <span class="text-[10px] font-medium mt-0.5">Keluar</span>
            </button>
        </form>
    </nav>
</body>
</html>