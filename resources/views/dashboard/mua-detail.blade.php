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

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                <span class="font-bold block mb-1">⚠️ Periksa data reservasi Anda:</span>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profil Header -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-3xl bg-rose-100 text-rose-700 text-xl font-bold flex items-center justify-center border border-rose-200">
                    {{ substr($mua->name, 0, 2) }}
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h1>
                    <p class="text-xs text-slate-500 mt-0.5">📍 {{ $mua->muaProfile->city ?? 'Padang' }} • Artisan: {{ $mua->name }}</p>

                    <!-- Rating Bintang Ringkas -->
                    <div class="flex items-center gap-1.5 text-xs mt-1">
                        <span class="text-amber-400 text-sm">★</span>
                        <span class="font-bold text-slate-800">{{ $averageRating > 0 ?$averageRating : 'Baru' }}</span>
                        <span class="text-slate-400">({{ $totalReviews }} ulasan)</span>
                    </div>

                    @if($mua->muaProfile &&$mua->muaProfile->instagram_username)
                        <a href="https://instagram.com/{{ ltrim($mua->muaProfile->instagram_username, '@') }}" target="_blank" class="text-xs text-rose-600 hover:underline font-medium mt-1 inline-block">
                            📸 @<span>{{ ltrim($mua->muaProfile->instagram_username, '@') }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tombol WhatsApp Langsung -->
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', (string)$mua->phone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                $waText = urlencode("Halo {$mua->name}, saya melihat profil studio Anda di GlowMUA dan ingin bertanya jadwal/booking rias.");
            @endphp
            <a href="https://wa.me/{{ $cleanPhone }}?text={{$waText }}" target="_blank"
                class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs sm:text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm shadow-emerald-200">
                <span>💬</span> Hubungi via WhatsApp
            </a>
        </div>

        <!-- Jadwal Jam Kerja MUA -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-xs">
            <h2 class="font-bold text-base text-slate-900 mb-3 flex items-center gap-2">
                <span>⏰</span> Jam Operasional Studio
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2">
                @php
                    $daysList = [
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        0 => 'Minggu',
                    ];
                    $schedulesMap =$mua->schedules->keyBy('day_of_week');
                @endphp
                @foreach ($daysList as $dIdx =>$dLabel)
                    @php
                        $sch = $schedulesMap->get($dIdx);
                        $isOpen =$sch ? $sch->is_active : ($dIdx !== 0);
                        $sTime =$sch ? \Carbon\Carbon::parse($sch->start_time)->format('H:i') : '08:00';$eTime = $sch ? \Carbon\Carbon::parse($sch->end_time)->format('H:i') : '17:00';
                    @endphp
                    <div class="p-2.5 rounded-xl border {{ $isOpen ? 'bg-slate-50/70 border-slate-200' : 'bg-rose-50/40 border-rose-100 opacity-60' }} text-center">
                        <span class="block text-[11px] font-bold text-slate-700">{{ $dLabel }}</span>
                        @if($isOpen)
                            <span class="block text-[10px] text-slate-500 font-medium mt-0.5">{{ $sTime }} - {{$eTime }}</span>
                        @else
                            <span class="block text-[10px] font-bold text-rose-600 mt-0.5">Libur</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Galeri Portofolio Riasan -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-xs">
            <h2 class="font-bold text-base text-slate-900 mb-4">Galeri Portofolio Hasil Rias</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                @forelse ($mua->portfolios as $porto)
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
                @forelse ($mua->services as $srv)
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

        <!-- Daftar Ulasan dari Klien -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-base text-slate-900">Ulasan dari Klien</h2>
                <span class="text-xs font-semibold text-rose-600">{{ $totalReviews }} Ulasan</span>
            </div>

            <div class="space-y-3">
                @forelse ($mua->muaReviews as $rev)
                    <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/70">
                        <div class="flex items-center justify-between">
                            <div class="font-bold text-xs text-slate-900">{{ $rev->client->name }}</div>
                            <div class="flex items-center gap-1 text-amber-500 text-xs font-bold">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <=$rev->rating ? '★' : '☆' }}</span>
                                @endfor
                                <span class="ml-1 text-slate-700">{{ $rev->rating }}.0</span>
                            </div>
                        </div>
                        @if($rev->comment)
                            <p class="text-xs text-slate-600 mt-1.5 italic">"{{ $rev->comment }}"</p>
                        @endif
                        <span class="text-[10px] text-slate-400 mt-2 block">{{ $rev->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="py-6 text-center text-xs text-slate-400">Belum ada ulasan untuk MUA ini.</p>
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
                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4" id="form-booking">
                            @csrf
                            <input type="hidden" name="mua_id" value="{{ $mua->id }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilih Paket Rias</label>
                                    <select name="service_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                        @foreach ($mua->services as $srv)
                                            <option value="{{ $srv->id }}" @selected(old('service_id') == $srv->id)>
                                                {{ $srv->title }} - Rp {{ number_format($srv->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tanggal Acara</label>
                                    <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                    <span id="date-helper" class="text-[11px] font-medium mt-1 block"></span>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Waktu / Jam Mulai Rias</label>
                                    <input type="time" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                    <span id="time-helper" class="text-[11px] text-slate-400 mt-1 block">Pilih tanggal terlebih dahulu</span>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Catatan Tambahan (Opsional)</label>
                                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Misal: request look soft korean / bawa lighting sendiri"
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Alamat Lengkap Lokasi Janji Rias</label>
                                    <textarea name="location_address" rows="2" required placeholder="Tuliskan alamat lengkap lokasi janji temu (contoh: Jl. Hamka No. 12, Hotel Truntum Padang Lt. 3)"
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-rose-500">{{ old('location_address') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" id="btn-submit-booking" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-rose-200">
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

    <!-- Script Penguncian Jam berdasarkan Jadwal MUA -->
    <script>
        const muaSchedules = @json($mua->schedules->keyBy('day_of_week'));
        const dateInput = document.getElementById('booking_date');
        const timeInput = document.getElementById('booking_time');
        const dateHelper = document.getElementById('date-helper');
        const timeHelper = document.getElementById('time-helper');
        const submitBtn = document.getElementById('btn-submit-booking');

        function checkAvailability() {
            if (!dateInput || !dateInput.value) return;

            const selectedDate = new Date(dateInput.value + 'T00:00:00');
            const dayOfWeek = selectedDate.getDay(); // 0 = Minggu, 1 = Senin, dst.

            let schedule = muaSchedules[dayOfWeek];

            // Fallback default jika MUA belum atur jadwal
            let isActive = schedule ? schedule.is_active : (dayOfWeek !== 0);
            let startTime = schedule ? schedule.start_time.substring(0, 5) : '08:00';
            let endTime = schedule ? schedule.end_time.substring(0, 5) : '17:00';

            if (!isActive) {
                dateHelper.textContent = '❌ MUA libur pada hari ini. Silakan pilih tanggal lain.';
                dateHelper.className = 'text-[11px] font-semibold text-rose-600 mt-1 block';
                timeInput.disabled = true;
                timeInput.value = '';
                timeHelper.textContent = 'Jam tidak tersedia karena MUA libur';
                timeHelper.className = 'text-[11px] text-rose-500 mt-1 block';
                if (submitBtn) submitBtn.disabled = true;
            } else {
                dateHelper.textContent = '✓ MUA buka pada hari ini.';
                dateHelper.className = 'text-[11px] font-medium text-emerald-600 mt-1 block';
                timeInput.disabled = false;
                timeInput.min = startTime;
                timeInput.max = endTime;
                timeHelper.textContent = `Pilih antara pukul ${startTime} s/d ${endTime} WIB`;
                timeHelper.className = 'text-[11px] text-slate-500 mt-1 block';
                if (submitBtn) submitBtn.disabled = false;
            }
        }

        if (dateInput) {
            dateInput.addEventListener('change', checkAvailability);
            if (dateInput.value) checkAvailability();
        }
    </script>
</body>
</html>