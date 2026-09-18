<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUA Dashboard - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex pb-16 md:pb-0 font-sans">

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-60 bg-white border-r border-rose-100 p-5 space-y-6 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">✨</span>
            <span class="font-bold text-lg text-slate-900">Glow<span class="text-rose-600">MUA</span></span>
        </a>

        <div class="px-3 py-2 bg-rose-50/80 rounded-xl border border-rose-100/60">
            <span class="text-[10px] uppercase font-bold text-rose-600 tracking-wider block">Mode Partner</span>
            <span class="text-xs font-semibold text-slate-800 truncate block">{{ $user->name }}</span>
        </div>

        <nav class="flex-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 bg-rose-50 text-rose-700 rounded-xl font-semibold text-xs">
                <span>📊</span> Ringkasan
            </a>
            <a href="#paket" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-rose-50/50 rounded-xl font-medium text-xs transition">
                <span>💄</span> Paket Rias ({{ $services->count() }})
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
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Studio MUA: {{ $profile->studio_name ?? $user->name }} 👋</h1>
                <p class="text-xs text-slate-500">Kelola jadwal booking dan tarif layanan riasmu</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-xs border border-rose-200 uppercase shadow-sm">
                {{ substr($user->name, 0, 2) }}
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center justify-between">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl text-lg">⏳</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Jadwal Masuk</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">0 Permintaan</h3>
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
                    <span class="text-[11px] text-slate-400 font-medium">Estimasi Pendapatan</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Rp 0</h3>
                </div>
            </div>
        </div>

        <!-- Form Profil Studio MUA -->
        <div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-6">
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
                    <input type="text" name="instagram_username" value="{{ old('instagram_username', $profile->instagram_username) }}" placeholder="tanpa @"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bio / Keahlian</label>
                    <input type="text" name="bio" value="{{ old('bio', $profile->bio) }}" placeholder="Spesialisasi riasan adat, wisuda glowing natural, dll."
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
                    <input type="text" name="title" required placeholder="Judul Riasan (misal: Wisuda Natural)"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <input type="url" name="image_url" required placeholder="URL Foto Gambar (https://...)"
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
                        <input type="text" name="title" required placeholder="Contoh: Makeup Wisuda Natural Glam"
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