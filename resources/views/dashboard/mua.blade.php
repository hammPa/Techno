<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUA Dashboard - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex pb-20 md:pb-0 font-sans">

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-60 bg-white border-r border-rose-100 p-5 space-y-6 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">✨</span>
            <span class="font-bold text-lg text-slate-900">Glow<span class="text-rose-600">MUA</span></span>
        </a>

        <div class="px-3 py-2 bg-rose-50/80 rounded-xl border border-rose-100/60">
            <span class="text-[10px] uppercase font-bold text-rose-600 tracking-wider block">Mode Partner MUA</span>
            <span class="text-xs font-semibold text-slate-800 truncate block">{{ $user->name }}</span>
        </div>

        <nav class="flex-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs">
                <span>📊</span> Ringkasan
            </a>
            <a href="#reservasi" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>📅</span> Reservasi ({{ $bookings->where('status', 'pending')->count() }})
            </a>
            <a href="#paket" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>💄</span> Paket Rias ({{ $services->count() }})
            </a>
            <a href="#profil" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>⚙️</span> Profil Studio
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
        <!-- Top Bar -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Studio: {{ $profile->studio_name ?? $user->name }} 👋</h1>
                <p class="text-xs text-slate-500">Kelola reservasi masuk, selesaikan job dengan kode verifikasi, dan kelola portofolio</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase shadow-sm">
                {{ substr($user->name, 0, 2) }}
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-xs">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <!-- Kartu Metrik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl text-lg">⏳</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Permintaan Baru</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $bookings->where('status', 'pending')->count() }} Booking</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl text-lg">💄</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Paket Rias Aktif</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $services->count() }} Paket</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl text-lg">💰</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Dana Masuk (Selesai)</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">
                        Rp {{ number_format($bookings->where('payment_status', 'released_to_mua')->sum('total_price'), 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Daftar Booking Masuk -->
        <div id="reservasi" class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Daftar Reservasi Masuk & Agenda</h2>
                    <p class="text-xs text-slate-400">Konfirmasi jadwal dan verifikasi kode penyelesaian setelah merias</p>
                </div>
                <span class="text-xs font-bold text-rose-600">{{ $bookings->where('status', 'pending')->count() }} Menunggu Jawaban</span>
            </div>

            <div class="space-y-4">
                @forelse($bookings as $bk)
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200">
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
                                        <form action="{{ route('bookings.updateStatus', $bk->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl text-xs font-semibold transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>

                                @elseif($bk->status === 'waiting_payment')
                                    <span class="text-xs text-amber-700 bg-amber-100/70 border border-amber-200 px-3 py-1.5 rounded-xl font-medium">
                                        Menunggu Bukti Transfer Klien
                                    </span>

                                @elseif($bk->status === 'confirmed')
                                    {{-- FORM VALIDASI KODE 4 DIGIT DARI KLIEN --}}
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
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada pesanan riasan yang masuk.</p>
                @endforelse
            </div>
        </div>

        <!-- Form Profil Studio MUA -->
        <div id="profil" class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-6">
            <h2 class="font-bold text-base text-slate-900 mb-3">Pengaturan Profil Studio</h2>
            <form action="{{ route('mua.profile.update') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Studio / Brand</label>
                    <input type="text" name="studio_name" value="{{ old('studio_name', $profile->studio_name) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kota Domisili</label>
                    <input type="text" name="city" value="{{ old('city', $profile->city) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Username Instagram</label>
                    <input type="text" name="instagram_username" value="{{ old('instagram_username', $profile->instagram_username) }}" placeholder="tanpa tanda @"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bio / Keahlian</label>
                    <input type="text" name="bio" value="{{ old('bio', $profile->bio) }}" placeholder="Spesialisasi riasan wisuda glowing, adat Minang, bridal modern, dll."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div class="sm:col-span-3 text-right">
                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Kelola Portofolio Foto -->
        <div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-6">
            <h2 class="font-bold text-base text-slate-900 mb-3">Foto Portofolio Riasan</h2>
            <form action="{{ route('mua.portfolio.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
                @csrf
                <div>
                    <input type="text" name="title" required placeholder="Judul Riasan (contoh: Wisuda Flawless)"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <input type="url" name="image_url" required placeholder="URL Gambar (https://...)"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition">
                        + Tambah Foto
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @forelse($portfolios as $p)
                    <div class="relative group rounded-xl overflow-hidden border border-slate-100">
                        <img src="{{ $p->image_url }}" alt="{{ $p->title }}" class="w-full h-32 object-cover">
                        <form action="{{ route('mua.portfolio.destroy', $p->id) }}" method="POST" class="absolute top-1.5 right-1.5" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-xs shadow-xs font-bold">×</button>
                        </form>
                    </div>
                @empty
                    <p class="col-span-full text-xs text-slate-400 text-center py-4">Belum ada portofolio yang diunggah.</p>
                @endforelse
            </div>
        </div>

        <!-- Section: Kelola Paket Riasan -->
        <div id="paket" class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Katalog Paket Layanan MUA</h2>
                    <p class="text-xs text-slate-400">Paket yang akan tampil dan bisa dipesan oleh calon klien</p>
                </div>
            </div>

            <!-- Form Tambah Paket Baru -->
            <form action="{{ route('services.store') }}" method="POST" class="bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80 mb-6 space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Paket Rias</label>
                        <input type="text" name="title" required placeholder="Contoh: Makeup Wisuda Glowing"
                            class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Kategori</label>
                        <select name="category" required class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                            <option value="graduation">Wisuda / Graduation</option>
                            <option value="wedding">Wedding / Bridal</option>
                            <option value="engagement">Lamaran / Engagement</option>
                            <option value="photoshoot">Photoshoot / Studio</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Harga (Rp)</label>
                        <input type="number" name="price" required placeholder="Contoh: 350000" min="0" step="5000"
                            class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Durasi (Menit)</label>
                        <input type="number" name="duration_minutes" value="120" required min="15" step="15"
                            class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Keterangan / Fasilitas</label>
                        <input type="text" name="description" placeholder="Termasuk hairdo/hijab do, bulu mata premium, dll."
                            class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-rose-500">
                    </div>
                </div>

                <div class="text-right pt-1">
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-xs transition shadow-sm">
                        + Tambah Paket
                    </button>
                </div>
            </form>

            <!-- List Paket Tersimpan -->
            <div class="space-y-3">
                @forelse($services as $item)
                    <div class="p-4 rounded-2xl bg-white border border-rose-100/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <span class="p-2.5 bg-rose-100 text-rose-700 rounded-xl text-base">💄</span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-sm text-slate-800">{{ $item->title }}</h4>
                                    <span class="text-[10px] px-2 py-0.5 bg-rose-50 text-rose-700 rounded-full font-semibold uppercase tracking-wider">{{ $item->category }}</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item->description ?? 'Tidak ada keterangan tambahan.' }}</p>
                                <span class="text-[11px] text-slate-400 mt-1 block">⏱ Durasi: {{ $item->duration_minutes }} menit</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-4 border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-100">
                            <span class="font-extrabold text-sm sm:text-base text-rose-600">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                            <form action="{{ route('services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus paket riasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs px-2.5 py-1 text-red-500 hover:bg-red-50 rounded-lg transition font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs">
                        Belum ada paket riasan yang ditambahkan. Buat paket pertama Anda pada form di atas.
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-rose-100 px-6 py-2 flex items-center justify-between z-50">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-rose-600">
            <span class="text-base">📊</span>
            <span class="text-[10px] font-semibold mt-0.5">Ringkasan</span>
        </a>
        <a href="#reservasi" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">📅</span>
            <span class="text-[10px] font-medium mt-0.5">Reservasi</span>
        </a>
        <a href="#paket" class="flex flex-col items-center text-slate-400 hover:text-rose-600">
            <span class="text-base">💄</span>
            <span class="text-[10px] font-medium mt-0.5">Paket</span>
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