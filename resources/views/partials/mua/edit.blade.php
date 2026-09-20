<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Riasan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased py-8 sm:py-12">
    <div class="max-w-2xl mx-auto px-4">
        
        <!-- Header Halaman -->
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl sm:text-2xl text-slate-900">Edit Paket Riasan</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Sesuaikan tarif, durasi kerja, atau fasilitas layanan Anda</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3.5 py-2 rounded-xl transition shadow-xs whitespace-nowrap">
                ← Batal & Kembali
            </a>
        </div>

        <!-- Alert Error Validasi jika ada -->
        @if($errors->any())
            <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs font-semibold">
                <p class="font-bold mb-1">Periksa kembali data yang dimasukkan:</p>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Form Edit -->
        <div class="bg-white rounded-3xl border border-rose-100 p-6 sm:p-8 shadow-sm">
            <form action="{{ route('services.update', $service->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <!-- Nama Paket -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Paket Rias</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}" required placeholder="Contoh: Makeup Wisuda Glowing"
                        class="w-full px-3.5 py-2.5 bg-slate-50/70 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-hidden focus:border-rose-500 focus:bg-white transition">
                </div>

                <!-- Kategori & Durasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Kategori</label>
                        <select name="category" required
                            class="w-full px-3.5 py-2.5 bg-slate-50/70 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-hidden focus:border-rose-500 focus:bg-white transition">
                            <option value="graduation" @selected(old('category', $service->category) === 'graduation')>Wisuda / Graduation</option>
                            <option value="wedding" @selected(old('category', $service->category) === 'wedding')>Wedding / Bridal</option>
                            <option value="engagement" @selected(old('category', $service->category) === 'engagement')>Lamaran / Engagement</option>
                            <option value="photoshoot" @selected(old('category', $service->category) === 'photoshoot')>Photoshoot / Studio</option>
                            <option value="other" @selected(old('category', $service->category) === 'other')>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Durasi Rias (Menit)</label>
                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" min="15" step="15" required
                            class="w-full px-3.5 py-2.5 bg-slate-50/70 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-hidden focus:border-rose-500 focus:bg-white transition">
                    </div>
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Harga Layanan (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', (int)$service->price) }}" min="0" step="5000" required placeholder="Contoh: 350000"
                        class="w-full px-3.5 py-2.5 bg-slate-50/70 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-hidden focus:border-rose-500 focus:bg-white transition">
                </div>

                <!-- Keterangan / Fasilitas -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Keterangan / Fasilitas</label>
                    <textarea name="description" rows="3" placeholder="Termasuk hairdo/hijab do, bulu mata premium, dll."
                        class="w-full px-3.5 py-2.5 bg-slate-50/70 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-hidden focus:border-rose-500 focus:bg-white transition">{{ old('description', $service->description) }}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2.5 text-xs font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition shadow-xs">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>
</html>