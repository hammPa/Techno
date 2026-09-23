<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Reservasi #{{ $booking->id }} - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen py-8 px-4 font-sans">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Navigasi Atas --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-rose-600 transition bg-white px-3.5 py-2 rounded-xl border border-rose-100 shadow-2xs">
                ← Kembali ke Dashboard
            </a>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-mono">Invoice #GM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                <button type="button" onclick="window.print()" class="text-xs font-semibold text-slate-600 hover:text-rose-600 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-2xs">
                    🖨️ Cetak
                </button>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl shadow-xs">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        {{-- Header & Tracker Status --}}
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-rose-600">Detail Reservasi Makeup</span>
                    <h1 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $booking->service->title }}</h1>
                    <p class="text-xs text-slate-500 mt-1">Dipesan pada {{ $booking->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                <div>
                    @if($booking->status === 'pending')
                        <span class="px-3.5 py-1.5 bg-amber-50 text-amber-800 border border-amber-200 rounded-full font-bold text-xs">Menunggu Konfirmasi MUA</span>
                    @elseif($booking->status === 'waiting_payment')
                        <span class="px-3.5 py-1.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full font-bold text-xs animate-pulse">Menunggu Pembayaran</span>
                    @elseif($booking->status === 'confirmed')
                        <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-bold text-xs">Jadwal Fix / Siap Melayani</span>
                    @elseif($booking->status === 'completed')
                        <span class="px-3.5 py-1.5 bg-blue-50 text-blue-800 border border-blue-200 rounded-full font-bold text-xs">Pesanan Selesai</span>
                    @else
                        <span class="px-3.5 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded-full font-bold text-xs">Dibatalkan</span>
                    @endif
                </div>
            </div>

            {{-- Visual Tracker Step --}}
            @if($booking->status !== 'cancelled')
                <div class="pt-6">
                    <div class="grid grid-cols-4 gap-2 text-center">
                        @php
                            $stepIndex = match($booking->status) {
                                'pending' => 1,
                                'waiting_payment' => 2,
                                'confirmed' => 3,
                                'completed' => 4,
                                default => 1
                            };
                        @endphp
                        <div>
                            <div class="w-7 h-7 mx-auto rounded-full flex items-center justify-center text-xs font-bold {{ $stepIndex >= 1 ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400' }}">1</div>
                            <span class="text-[11px] font-semibold block mt-1.5 {{ $stepIndex >= 1 ? 'text-slate-800' : 'text-slate-400' }}">Pemesanan</span>
                        </div>
                        <div>
                            <div class="w-7 h-7 mx-auto rounded-full flex items-center justify-center text-xs font-bold {{ $stepIndex >= 2 ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400' }}">2</div>
                            <span class="text-[11px] font-semibold block mt-1.5 {{ $stepIndex >= 2 ? 'text-slate-800' : 'text-slate-400' }}">Pembayaran</span>
                        </div>
                        <div>
                            <div class="w-7 h-7 mx-auto rounded-full flex items-center justify-center text-xs font-bold {{ $stepIndex >= 3 ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400' }}">3</div>
                            <span class="text-[11px] font-semibold block mt-1.5 {{ $stepIndex >= 3 ? 'text-slate-800' : 'text-slate-400' }}">Jadwal Siap</span>
                        </div>
                        <div>
                            <div class="w-7 h-7 mx-auto rounded-full flex items-center justify-center text-xs font-bold {{ $stepIndex >= 4 ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400' }}">4</div>
                            <span class="text-[11px] font-semibold block mt-1.5 {{ $stepIndex >= 4 ? 'text-slate-800' : 'text-slate-400' }}">Penyelesaian</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Grid Informasi Utama (2 Kolom) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Detail Agenda & Pihak Terkait (2 Span) --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Waktu & Tempat Acara --}}
                <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm space-y-4">
                    <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>📍</span> Jadwal & Lokasi Acara
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Hari & Tanggal</span>
                            <span class="font-bold text-slate-800 mt-0.5 block text-sm">📅 {{ date('d F Y', strtotime($booking->booking_date)) }}</span>
                        </div>
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Waktu Sesi Makeup</span>
                            <span class="font-bold text-slate-800 mt-0.5 block text-sm">⏰ Pukul {{ date('H:i', strtotime($booking->booking_time)) }} WIB</span>
                        </div>
                    </div>
                    <div class="text-xs space-y-1">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Alamat Lengkap</span>
                        <p class="text-slate-700 font-medium leading-relaxed">{{ $booking->location_address }}</p>
                    </div>
                    @if($booking->notes)
                        <div class="text-xs p-3 bg-rose-50/50 rounded-xl border border-rose-100 text-rose-900">
                            <strong>Catatan Pemesan:</strong> "{{ $booking->notes }}"
                        </div>
                    @endif
                </div>

                {{-- Informasi Pihak Terlibat (Klien & MUA) --}}
                <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>👥</span> Kontak Pihak Terkait
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 text-xs">
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 space-y-1">
                            <span class="text-[10px] text-rose-600 font-bold uppercase">Klien (Pemesan)</span>
                            <p class="font-bold text-slate-800 text-sm">{{ $booking->client->name }}</p>
                            <p class="text-slate-500">Email: {{ $booking->client->email }}</p>
                            <p class="text-slate-500">No. WhatsApp: 
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->client->phone) }}" target="_blank" class="text-rose-600 font-semibold underline">
                                    {{ $booking->client->phone }}
                                </a>
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 space-y-1">
                            <span class="text-[10px] text-rose-600 font-bold uppercase">Partner MUA</span>
                            <p class="font-bold text-slate-800 text-sm">{{ $booking->mua->muaProfile->studio_name ?? $booking->mua->name }}</p>
                            <p class="text-slate-500">Area: {{ $booking->mua->muaProfile->city ?? '-' }}</p>
                            <p class="text-slate-500">No. WhatsApp: 
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->mua->phone) }}" target="_blank" class="text-rose-600 font-semibold underline">
                                    {{ $booking->mua->phone }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Pembayaran (Log Riil) --}}
                <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>🧾</span> Riwayat Transfer Pembayaran
                    </h2>
                    <div class="mt-4 space-y-3">
                        @forelse($booking->payments as $payment)
                            <div class="p-3.5 rounded-2xl border border-slate-100 bg-slate-50/80 flex items-center justify-between text-xs">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800 uppercase">{{ $payment->payment_type ?? 'Transfer' }} ({{ $payment->bank_name }})</span>
                                        @if($payment->status === 'verified')
                                            <span class="text-[10px] font-bold px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-md">Terverifikasi</span>
                                        @elseif($payment->status === 'waiting_verification')
                                            <span class="text-[10px] font-bold px-2 py-0.5 bg-amber-100 text-amber-800 rounded-md">Verifikasi Admin</span>
                                        @else
                                            <span class="text-[10px] font-bold px-2 py-0.5 bg-red-100 text-red-800 rounded-md">Ditolak</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5">A.n. {{ $payment->sender_name }} • {{ $payment->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <span class="font-extrabold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic text-center py-3">Belum ada catatan transaksi pembayaran.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Rincian Tagihan & Panel Eksekusi Aksi (1 Span) --}}
            <div class="space-y-6">

                {{-- Kartu Ringkasan Tagihan (Billing) --}}
                <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Rincian Pembayaran</h3>
                    @php
                        $totalVerifiedPaid = $booking->payments->where('status', 'verified')->sum('amount');
                        $remainingBill = max(0, $booking->total_price - $totalVerifiedPaid);
                    @endphp
                    <div class="space-y-2.5 text-xs pb-4 border-b border-slate-100">
                        <div class="flex justify-between text-slate-600">
                            <span>Harga Layanan</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Total Masuk / Diverifikasi</span>
                            <span class="font-semibold text-emerald-600">- Rp {{ number_format($totalVerifiedPaid, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Status Bayar</span>
                            <span class="font-bold text-slate-800 uppercase">{{ str_replace('_', ' ', $booking->payment_status) }}</span>
                        </div>
                    </div>
                    <div class="pt-4 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700">Sisa Tagihan:</span>
                        <span class="text-lg font-black text-rose-600">Rp {{ number_format($remainingBill, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Panel Aksi (MUA vs Klien) Menggunakan Card Asli Anda --}}
                <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Panel Tindakan</h3>
                    @if(auth()->user()->role === 'mua')
                        @include('partials.mua.single-reservation-card', ['bk' => $booking])
                    @else
                        @include('partials.client.single-booking-card', ['b' => $booking])
                    @endif
                </div>

            </div>

        </div>

    </div>

    @include('partials.modal-cancel-booking')
    @include('partials.modal-review')
</body>
</html>