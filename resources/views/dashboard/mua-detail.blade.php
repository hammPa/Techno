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
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-rose-600 transition">
            ← {{ auth()->check() ? 'Kembali ke Marketplace' : 'Kembali ke Beranda' }}
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
                    @if($mua->muaProfile && $mua->muaProfile->instagram_username)
                        <a href="https://instagram.com/{{ ltrim($mua->muaProfile->instagram_username, '@') }}" target="_blank" class="text-xs text-rose-600 hover:underline font-medium mt-1 inline-block">
                            📸 @<span>{{ ltrim($mua->muaProfile->instagram_username, '@') }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tombol WhatsApp Langsung -->
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', (string) $mua->phone);
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
                    @php
                        $imgSrc = str_starts_with($porto->image_url, 'http') ? $porto->image_url : Storage::url($porto->image_url);
                    @endphp
                    <div class="rounded-2xl overflow-hidden border border-slate-100 group relative">
                        <img src="{{ $imgSrc }}" alt="{{ $porto->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
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

        <!-- Form Pengajuan Booking Jadwal & Lokasi -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-xs">
            <div class="mb-4">
                <h2 class="font-bold text-base text-slate-900">Reservasi Jadwal Rias</h2>
                <p class="text-xs text-slate-500">Tentukan jadwal rias dan lokasi acara Anda</p>
            </div>

            @auth
                @if(auth()->user()->role === 'client')
                    @if($mua->services->count() > 0)
                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="mua_id" value="{{ $mua->id }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilih Paket Rias</label>
                                    <select name="service_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                        @foreach($mua->services as $srv)
                                            <option value="{{ $srv->id }}">
                                                {{ $srv->title }} - Rp {{ number_format($srv->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tanggal Acara</label>
                                    <input type="date" name="booking_date" min="{{ date('Y-m-d') }}" required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Waktu / Jam Mulai Rias</label>
                                    <input type="time" name="booking_time" required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Catatan Tambahan (Opsional)</label>
                                    <input type="text" name="notes" placeholder="Misal: request look soft korean / bawa lighting sendiri"
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Alamat Lengkap Lokasi Janji Rias</label>
                                    <textarea name="location_address" rows="2" required placeholder="Tuliskan alamat lengkap lokasi janji temu (contoh: Jl. Hamka No. 12, Hotel Truntum Padang Lt. 3)"
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-rose-200">
                                Ajukan Jadwal Booking Sekarang
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-slate-400 py-4 text-center">MUA ini belum membuka paket pemesanan.</p>
                    @endif
                @else
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs text-center">
                        Anda masuk dengan akun MUA. Masuklah dengan akun Klien jika ingin mengajukan reservasi.
                    </div>
                @endif
            @else
                <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl text-center space-y-2">
                    <p class="text-xs text-slate-600 font-medium">Masuk terlebih dahulu untuk melakukan reservasi jadwal riasan dengan MUA ini.</p>
                    <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold transition">
                        Masuk Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
</body>
</html>