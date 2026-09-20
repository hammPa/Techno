<div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
        <div>
            <h2 class="font-bold text-base text-slate-900">Katalog Paket Layanan MUA</h2>
            <p class="text-xs text-slate-400">Paket yang akan tampil dan bisa dipesan oleh calon klien</p>
        </div>
        <span class="text-xs font-bold text-rose-600">{{ $services->count() }} Paket Tersedia</span>
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

                <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-2 sm:pt-0 border-slate-100">
                    <span class="font-extrabold text-sm sm:text-base text-rose-600">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </span>
                    
                    <div class="flex items-center gap-1">
                        <!-- Link ke Halaman Edit Terpisah -->
                        <a href="{{ route('services.edit', $item->id) }}" 
                        class="text-xs px-2.5 py-1 text-amber-600 hover:bg-amber-50 rounded-lg transition font-semibold">
                            Edit
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus paket riasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs px-2.5 py-1 text-red-500 hover:bg-red-50 rounded-lg transition font-semibold">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-slate-400 text-xs">
                Belum ada paket riasan yang ditambahkan. Buat paket pertama Anda pada form di atas.
            </div>
        @endforelse
    </div>
</div>