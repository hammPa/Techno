<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $mua->muaProfile->studio_name ?? $mua->name }} - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen py-6 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-rose-600 transition">
            ← Kembali ke Marketplace
        </a>

        <!-- Profil Header -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-3xl bg-rose-100 text-rose-700 text-xl font-bold flex items-center justify-center border border-rose-200">
                    {{ substr($mua->name, 0, 2) }}
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h1>
                    <p class="text-xs text-slate-500 mt-0.5">📍 {{ $mua->muaProfile->city ?? 'Padang' }} • Artisan: {{ $mua->name }}</p>
                    @if($mua->muaProfile->instagram_username)
                        <span class="text-xs text-rose-600 font-medium mt-1 block">📸 @ {{ $mua->muaProfile->instagram_username }}</span>
                    @endif
                </div>
            </div>

            <!-- Tombol WhatsApp Langsung -->
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $mua->phone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                $waText = urlencode("Halo {$mua->name}, saya melihat profil studio Anda di GlowMUA dan ingin bertanya jadwal/booking rias.");
            @endphp
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank"
                class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs sm:text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm shadow-emerald-200">
                <span>💬</span> Hubungi via WhatsApp
            </a>
        </div>

        <!-- Galeri Portofolio Riasan -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-xs">
            <h2 class="font-bold text-base text-slate-900 mb-4">Galeri Portofolio Hasil Rias</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                @forelse($mua->portfolios as $porto)
                    <div class="rounded-2xl overflow-hidden border border-slate-100 group relative">
                        <img src="{{ $porto->image_url }}" alt="{{ $porto->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                        <span class="absolute bottom-2 left-2 right-2 bg-black/60 backdrop-blur-xs text-white text-[11px] px-2 py-1 rounded-lg truncate">
                            {{ $porto->title }}
                        </span>
                    </div>
                @empty
                    <p class="col-span-full py-8 text-center text-xs text-slate-400">MUA ini belum mengunggah foto portofolio.</p>
                @endforelse
            </div>
        </div>

        <!-- Daftar Paket Rias & Janji Temu -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-xs">
            <h2 class="font-bold text-base text-slate-900 mb-4">Pilihan Paket & Tarif</h2>
            <div class="space-y-3">
                @forelse($mua->services as $srv)
                    <div class="p-4 rounded-2xl bg-slate-50/60 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-sm text-slate-800">{{ $srv->title }}</h3>
                                <span class="text-[10px] px-2 py-0.5 bg-rose-100 text-rose-700 rounded-full font-semibold uppercase">{{ $srv->category }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">{{ $srv->description ?? 'Sudah termasuk hairdo/hijab do dan bulu mata.' }}</p>
                            <span class="text-[11px] text-slate-400 mt-1 block">⏱ Durasi: {{ $srv->duration_minutes }} menit</span>
                        </div>
                        <div class="text-left sm:text-right border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-200">
                            <span class="text-base font-extrabold text-rose-600 block">Rp {{ number_format($srv->price, 0, ',', '.') }}</span>
                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode("Halo {$mua->name}, saya ingin booking paket '{$srv->title}' seharga Rp " . number_format($srv->price, 0, ',', '.')) }}" target="_blank"
                                class="inline-block mt-1 text-[11px] text-emerald-700 font-bold hover:underline">
                                Atur Tanggal Booking →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-xs text-slate-400">Belum ada paket tarif yang terdaftar.</p>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>