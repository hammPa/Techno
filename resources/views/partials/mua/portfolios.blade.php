<div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm">
    <div class="flex items-center justify-between mb-3">
        <div>
            <h2 class="font-bold text-base text-slate-900">Foto Portofolio Riasan</h2>
            <p class="text-xs text-slate-400">Unggah hasil karya rias terbaik untuk menarik minat calon klien</p>
        </div>
        <span class="text-xs font-bold text-rose-600">{{ $portfolios->count() }} Foto</span>
    </div>

    <!-- Form Upload Foto Portofolio -->
    <form action="{{ route('mua.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
        @csrf
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Judul Riasan</label>
            <input type="text" name="title" required placeholder="Contoh: Wisuda Flawless Glowing"
                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Pilih File Foto (Maks 3MB)</label>
            <input type="file" name="image" accept="image/*" required
                class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-rose-600 transition">
        </div>
        <div class="sm:self-end">
            <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                + Upload Portofolio
            </button>
        </div>
    </form>

    <!-- Grid List Portofolio -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @forelse($portfolios as $p)
            <div class="relative group rounded-xl overflow-hidden border border-slate-100 shadow-xs">
                @php
                    $src = str_starts_with($p->image_url, 'http') ? $p->image_url : Storage::url($p->image_url);
                @endphp
                <img src="{{ $src }}" alt="{{ $p->title }}" class="w-full h-32 object-cover group-hover:scale-105 transition duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition p-2 flex flex-col justify-between">
                    <form action="{{ route('mua.portfolio.destroy', $p->id) }}" method="POST" class="self-end" onsubmit="return confirm('Hapus foto ini dari portofolio?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-xs shadow-xs font-bold hover:bg-red-700">×</button>
                    </form>
                    <span class="text-[10px] text-white font-medium truncate">{{ $p->title }}</span>
                </div>
            </div>
        @empty
            <p class="col-span-full text-xs text-slate-400 text-center py-6">Belum ada foto portofolio yang diunggah.</p>
        @endforelse
    </div>
</div>