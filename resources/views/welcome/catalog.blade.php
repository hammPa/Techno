<section id="katalog" class="max-w-6xl mx-auto px-4 sm:px-6 pb-20 scroll-mt-20">
    <div class="flex items-baseline justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">
                @if(request('q') || request('category'))
                    Hasil pencarian
                @else
                    Daftar MUA teratas
                @endif
            </h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">
                @if(request('q') || request('category'))
                    {{ $muaList->total() }} MUA ditemukan.
                @endif
                Lihat portofolio rias, ulasan klien, dan estimasi harga paket.
            </p>
        </div>

        @if(request('q') || request('category'))
            <a href="{{ route('home') }}#katalog"
               class="shrink-0 text-sm text-[#3b2230]/60 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/25 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                Reset filter
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($muaList as $mua)
            @include('welcome.mua-card', ['mua' => $mua])
        @empty
            <div class="col-span-full py-16 text-center bg-white border border-dashed border-[#3b2230]/20 rounded-lg">
                <h3 class="text-lg [font-family:'Fraunces',serif] font-normal">Tidak ada MUA yang sesuai</h3>
                <p class="mt-1 text-sm text-[#3b2230]/60">Coba kata kunci atau kota lain, atau reset filter pencarian.</p>
                @if(request('q') || request('category'))
                    <a href="{{ route('home') }}#katalog"
                       class="inline-block mt-4 px-4 py-2 text-sm font-semibold text-[#3b2230] border border-[#3b2230]/25 hover:border-[#3b2230]/60 hover:bg-[#3b2230]/[0.04] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                        Tampilkan semua MUA
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $muaList->fragment('katalog')->links() }}
    </div>
</section>