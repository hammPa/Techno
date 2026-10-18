<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $mua->muaProfile->studio_name ?? $mua->name }} - GlowMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,400;9..144,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] [font-family:'DM_Sans',system-ui,sans-serif] antialiased min-h-screen py-6 px-4 sm:px-6 lg:px-10 lg:py-10">
    <div class="max-w-6xl mx-auto">

        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}"
            class="inline-flex items-center gap-2 text-sm text-[#3b2230]/65 hover:text-[#3b2230] transition-colors">
            <span aria-hidden="true">←</span>
            {{ auth()->check() ? 'Kembali ke marketplace' : 'Kembali ke beranda' }}
        </a>

        @if($errors->any())
            <div class="mt-5 px-4 py-3 border-l-2 border-[#3b2230]/60 bg-[#3b2230]/[0.06] text-sm">
                <span class="font-semibold block mb-1">Periksa data reservasi Anda:</span>
                <ul class="list-disc pl-5 space-y-0.5 text-[#3b2230]/80">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profil header -->
        <header class="mt-5 p-6 sm:p-8 bg-white border border-[#3b2230]/10 rounded-lg flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-5 min-w-0">
                <div class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#3b2230] text-[#faf6f1] text-xl sm:text-2xl font-medium uppercase flex items-center justify-center">
                    {{ substr($mua->name, 0, 2) }}
                </div>
                <div class="min-w-0">
                    <h1 class="text-3xl sm:text-4xl leading-tight [font-family:'Fraunces',serif] font-normal">{{ $mua->muaProfile->studio_name ?? $mua->name }}</h1>
                    <p class="mt-1 text-sm text-[#3b2230]/60">{{ $mua->muaProfile->city ?? 'Padang' }} · Artisan: {{ $mua->name }}</p>

                    <!-- Rating ringkas -->
                    <div class="mt-2 flex items-center gap-1.5 text-sm">
                        <span aria-hidden="true">★</span>
                        <span class="font-semibold">{{ $averageRating > 0 ? $averageRating : 'Baru' }}</span>
                        <span class="text-[#3b2230]/55">({{ $totalReviews }} ulasan)</span>
                    </div>

                    @if($mua->muaProfile && $mua->muaProfile->instagram_username)
                        <a href="https://instagram.com/{{ ltrim($mua->muaProfile->instagram_username, '@') }}" target="_blank" rel="noopener"
                            class="mt-1.5 inline-block text-sm underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230]">
                            Instagram @<span>{{ ltrim($mua->muaProfile->instagram_username, '@') }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tombol WhatsApp langsung -->
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', (string) $mua->phone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                $waText = urlencode("Halo {$mua->name}, saya melihat profil studio Anda di GlowMUA dan ingin bertanya jadwal/booking rias.");
            @endphp
            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" rel="noopener"
                class="shrink-0 px-5 py-3 bg-[#3b2230] hover:bg-[#2a1620] text-[#faf6f1] rounded-md text-sm font-medium text-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">
                Hubungi via WhatsApp
            </a>
        </header>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-[1fr_24rem] gap-6 items-start">

            <!-- Kolom utama -->
            <div class="space-y-6 min-w-0">

                <!-- Jam operasional -->
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-5">Jam operasional studio</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 xl:grid-cols-7 gap-2">
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
                            $schedulesMap = $mua->schedules->keyBy('day_of_week');
                        @endphp
                        @foreach ($daysList as $dIdx => $dLabel)
                            @php
                                $sch = $schedulesMap->get($dIdx);
                                $isOpen = $sch ? $sch->is_active : ($dIdx !== 0);
                                $sTime = $sch ? \Carbon\Carbon::parse($sch->start_time)->format('H:i') : '08:00';
                                $eTime = $sch ? \Carbon\Carbon::parse($sch->end_time)->format('H:i') : '17:00';
                            @endphp
                            <div class="px-2 py-3 rounded-md border text-center {{ $isOpen ? 'bg-[#faf6f1] border-[#3b2230]/10' : 'bg-[#3b2230]/[0.05] border-transparent text-[#3b2230]/45' }}">
                                <span class="block text-xs font-semibold">{{ $dLabel }}</span>
                                @if($isOpen)
                                    <span class="block mt-1 text-xs text-[#3b2230]/65">{{ $sTime }} – {{ $eTime }}</span>
                                @else
                                    <span class="block mt-1 text-xs">Libur</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Galeri portofolio -->
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-5">Galeri portofolio hasil rias</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @forelse ($mua->portfolios as $porto)
                            @php
                                $imgSrc = str_starts_with($porto->image_url, 'http') ? $porto->image_url : Storage::url($porto->image_url);
                            @endphp
                            <figure class="group">
                                <div class="aspect-[4/5] overflow-hidden rounded-md bg-[#3b2230]/[0.07]">
                                    <img src="{{ $imgSrc }}" alt="{{ $porto->title }}" loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
                                </div>
                                <figcaption class="mt-2 text-xs text-[#3b2230]/65 truncate">{{ $porto->title }}</figcaption>
                            </figure>
                        @empty
                            <p class="col-span-full py-10 text-center text-sm text-[#3b2230]/60 border border-dashed border-[#3b2230]/20 rounded-md">
                                MUA ini belum mengunggah foto portofolio.
                            </p>
                        @endforelse
                    </div>
                </section>

                <!-- Paket & tarif -->
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal mb-2">Pilihan paket &amp; tarif</h2>
                    <div>
                        @forelse ($mua->services as $srv)
                            <article class="py-5 border-b border-[#3b2230]/10 last:border-b-0 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-base font-semibold">{{ $srv->title }}</h3>
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#3b2230]/[0.08] uppercase tracking-wide">{{ $srv->category }}</span>
                                    </div>
                                    <p class="mt-1.5 text-sm text-[#3b2230]/65 leading-relaxed">{{ $srv->description ?? 'Sudah termasuk hairdo/hijab do dan bulu mata.' }}</p>
                                    <span class="mt-1.5 block text-xs text-[#3b2230]/50">Durasi: {{ $srv->duration_minutes }} menit</span>
                                </div>
                                <div class="shrink-0 sm:text-right">
                                    <span class="block text-2xl [font-family:'Fraunces',serif] leading-tight">Rp {{ number_format($srv->price, 0, ',', '.') }}</span>
                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode("Halo {$mua->name}, saya ingin booking paket '{$srv->title}' seharga Rp " . number_format($srv->price, 0, ',', '.')) }}" target="_blank" rel="noopener"
                                        class="inline-block mt-1.5 text-sm underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230]">
                                        Atur tanggal booking →
                                    </a>
                                </div>
                            </article>
                        @empty
                            <p class="py-10 text-center text-sm text-[#3b2230]/60">Belum ada paket tarif yang terdaftar.</p>
                        @endforelse
                    </div>
                </section>

                <!-- Ulasan klien -->
                <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                    <div class="flex items-baseline justify-between gap-4 mb-2">
                        <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Ulasan dari klien</h2>
                        <span class="text-sm text-[#3b2230]/60">{{ $totalReviews }} ulasan</span>
                    </div>

                    @forelse ($mua->muaReviews as $rev)
                        <article class="py-5 border-b border-[#3b2230]/10 last:border-b-0">
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="text-sm font-semibold truncate">{{ $rev->client->name }}</h3>
                                <div class="shrink-0 flex items-center gap-1 text-sm" aria-label="Rating {{ $rev->rating }} dari 5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $rev->rating ? '' : 'text-[#3b2230]/25' }}">★</span>
                                    @endfor
                                    <span class="ml-1 text-xs text-[#3b2230]/65">{{ $rev->rating }}.0</span>
                                </div>
                            </div>
                            @if($rev->comment)
                                <p class="mt-2 text-sm leading-relaxed text-[#3b2230]/80 italic">“{{ $rev->comment }}”</p>
                            @endif
                            <span class="mt-2 block text-xs text-[#3b2230]/50">{{ $rev->created_at->diffForHumans() }}</span>
                        </article>
                    @empty
                        <p class="py-10 text-center text-sm text-[#3b2230]/60">Belum ada ulasan untuk MUA ini.</p>
                    @endforelse
                </section>
            </div>

            <!-- Form reservasi (menempel di desktop) -->
            <aside class="lg:sticky lg:top-6 p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
                <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Reservasi jadwal rias</h2>
                <p class="mt-1.5 mb-6 text-sm text-[#3b2230]/60">Tentukan jadwal rias dan lokasi acara Anda.</p>

                @auth
                    @if(auth()->user()->role === 'client')
                        @if($mua->services->count() > 0)
                            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5" id="form-booking">
                                @csrf
                                <input type="hidden" name="mua_id" value="{{ $mua->id }}">

                                <div>
                                    <label for="service_id" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Pilih paket rias</label>
                                    <select id="service_id" name="service_id" required
                                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                        @foreach ($mua->services as $srv)
                                            <option value="{{ $srv->id }}" @selected(old('service_id') == $srv->id)>
                                                {{ $srv->title }} - Rp {{ number_format($srv->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="booking_date" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Tanggal acara</label>
                                    <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required
                                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                    <span id="date-helper" class="mt-1.5 block text-xs"></span>
                                </div>

                                <div>
                                    <label for="booking_time" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Waktu / jam mulai rias</label>
                                    <input type="time" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required
                                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm focus:outline-none focus:ring-0 focus:border-[#3b2230] disabled:bg-[#3b2230]/[0.05] disabled:text-[#3b2230]/40">
                                    <span id="time-helper" class="mt-1.5 block text-xs text-[#3b2230]/55">Pilih tanggal terlebih dahulu</span>
                                </div>

                                <div>
                                    <label for="notes" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Catatan tambahan (opsional)</label>
                                    <input type="text" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Misal: request look soft korean / bawa lighting sendiri"
                                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">
                                </div>

                                <div>
                                    <label for="location_address" class="block text-xs font-medium text-[#3b2230]/70 mb-1.5">Alamat lengkap lokasi janji rias</label>
                                    <textarea id="location_address" name="location_address" rows="3" required placeholder="Tuliskan alamat lengkap lokasi janji temu (contoh: Jl. Hamka No. 12, Hotel Truntum Padang Lt. 3)"
                                        class="w-full px-3 py-2.5 bg-white border border-[#3b2230]/20 rounded-md text-sm placeholder:text-[#3b2230]/30 focus:outline-none focus:ring-0 focus:border-[#3b2230]">{{ old('location_address') }}</textarea>
                                </div>

                                <button type="submit" id="btn-submit-booking"
                                    class="w-full py-3 bg-[#3b2230] hover:bg-[#2a1620] disabled:opacity-40 disabled:cursor-not-allowed text-[#faf6f1] text-sm font-medium rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">
                                    Ajukan jadwal booking sekarang
                                </button>
                            </form>
                        @else
                            <p class="py-6 text-center text-sm text-[#3b2230]/60">MUA ini belum membuka paket pemesanan.</p>
                        @endif
                    @else
                        <div class="px-4 py-3 bg-[#f3e6c8]/60 border-l-2 border-[#7a5a14]/50 text-sm text-[#7a5a14]">
                            Anda masuk dengan akun MUA. Masuklah dengan akun Klien jika ingin mengajukan reservasi.
                        </div>
                    @endif
                @else
                    <div class="p-5 bg-[#faf6f1] border border-[#3b2230]/10 rounded-md space-y-3">
                        <p class="text-sm text-[#3b2230]/75">Masuk terlebih dahulu untuk melakukan reservasi jadwal riasan dengan MUA ini.</p>
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-2.5 bg-[#3b2230] hover:bg-[#2a1620] text-[#faf6f1] rounded-md text-sm font-medium transition-colors">
                            Masuk sekarang
                        </a>
                    </div>
                @endauth
            </aside>
        </div>
    </div>

    <!-- Script penguncian jam berdasarkan jadwal MUA -->
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
                dateHelper.textContent = 'MUA libur pada hari ini. Silakan pilih tanggal lain.';
                dateHelper.className = 'mt-1.5 block text-xs font-semibold text-[#3b2230]';
                timeInput.disabled = true;
                timeInput.value = '';
                timeHelper.textContent = 'Jam tidak tersedia karena MUA libur';
                timeHelper.className = 'mt-1.5 block text-xs text-[#3b2230]/55';
                if (submitBtn) submitBtn.disabled = true;
            } else {
                dateHelper.textContent = 'MUA buka pada hari ini.';
                dateHelper.className = 'mt-1.5 block text-xs font-medium text-[#2f5a3c]';
                timeInput.disabled = false;
                timeInput.min = startTime;
                timeInput.max = endTime;
                timeHelper.textContent = `Pilih antara pukul ${startTime} s/d ${endTime} WIB`;
                timeHelper.className = 'mt-1.5 block text-xs text-[#3b2230]/55';
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