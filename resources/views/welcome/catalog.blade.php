<section id="katalog" class="max-w-6xl mx-auto px-4 sm:px-6 pb-20">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                @if(request('q') || request('category'))
                    Hasil Pencarian
                    <span class="text-xs font-normal text-slate-400">
                        ({{ $muaList->total() }} MUA ditemukan)
                    </span>
                @else
                    Daftar MUA Teratas
                @endif
            </h2>
            <p class="text-xs text-slate-400">Lihat portofolio rias, review klien asli, dan estimasi paket harga</p>
        </div>

        @if(request('q') || request('category'))
            <a href="{{ route('home') }}#katalog" class="text-xs font-semibold text-rose-600 hover:underline">
                Reset Filter
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($muaList as $mua)
            {{-- Memanggil komponen mua-card dari folder welcome --}}
            @include('welcome.mua-card', ['mua' => $mua])
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-rose-100">
                <h3 class="font-bold text-sm text-slate-800">Tidak ada MUA yang sesuai</h3>
                <p class="text-xs text-slate-400 mt-1">Coba cari kata kunci atau kota lain, atau reset filter pencarianmu.</p>
                @if(request('q') || request('category'))
                    <a href="{{ route('home') }}#katalog" class="inline-block mt-3 px-4 py-2 bg-rose-50 text-rose-700 rounded-xl text-xs font-semibold hover:bg-rose-100 transition">
                        Tampilkan Semua MUA
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Navigasi Halaman Pagination -->
    <div class="mt-8">
        {{ $muaList->fragment('katalog')->links() }}
    </div>
</section>