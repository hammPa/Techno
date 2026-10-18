{{-- partials/client/marketplace.blade.php --}}
<div>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 mb-6">
        <div>
            <h2 class="text-2xl lg:text-3xl [font-family:'Fraunces',serif] font-normal leading-tight">Katalog pilihan makeup artist</h2>
            <p class="mt-1.5 text-sm text-[#3b2230]/60">Pilih MUA dan atur jadwal janji rias langsung.</p>
        </div>
        <span class="text-sm text-[#3b2230]/60">
            {{ method_exists($muaList, 'total') ? $muaList->total() : $muaList->count() }} terverifikasi
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($muaList as $mua)
            @include('welcome.mua-card', ['mua' => $mua])
        @empty
            <div class="col-span-full py-16 text-center bg-white border border-dashed border-[#3b2230]/20 rounded-lg">
                <p class="text-sm font-medium">Belum ada MUA terverifikasi yang tersedia.</p>
                <p class="mt-1 text-xs text-[#3b2230]/55">Silakan periksa kembali beberapa saat lagi.</p>
            </div>
        @endforelse
    </div>

    @if(method_exists($muaList, 'links'))
        <div class="mt-8">
            {{ $muaList->fragment('marketplace')->links() }}
        </div>
    @endif
</div>