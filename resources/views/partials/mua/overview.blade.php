@php
    $portfolios   = $portfolios ?? collect();
    $reviews      = $reviews ?? collect();
    $reviewsCount = $reviewsCount ?? $reviews->count();
    $pendingCount = $bookings->where('status', 'pending')->count();
@endphp

<div class="space-y-6">

    <!-- Kartu Metrik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <!-- Permintaan Baru -->
        <div class="flex items-center gap-4 p-5 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="shrink-0 w-11 h-11 rounded-md bg-[#3b2230]/[0.07] text-[#3b2230] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="min-w-0">
                <span class="block text-sm font-semibold truncate">Permintaan baru</span>
                <span class="block mt-0.5 text-sm text-[#3b2230]/60">{{ $pendingCount }} booking</span>
            </div>
        </div>

        <!-- Paket Rias Aktif -->
        <div class="flex items-center gap-4 p-5 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="shrink-0 w-11 h-11 rounded-md bg-[#3b2230]/[0.07] text-[#3b2230] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="min-w-0">
                <span class="block text-sm font-semibold truncate">Paket rias aktif</span>
                <span class="block mt-0.5 text-sm text-[#3b2230]/60">{{ $services->count() }} paket</span>
            </div>
        </div>

        <!-- Saldo -->
        <div class="flex items-center gap-4 p-5 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="shrink-0 w-11 h-11 rounded-md bg-[#3b2230]/[0.07] text-[#3b2230] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="min-w-0">
                <span class="block text-sm font-semibold truncate">Saldo dapat ditarik</span>
                <span class="block mt-0.5 text-sm text-[#3b2230]/60">Rp {{ number_format($user->available_balance, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat Studio (4 navigasi) -->
    <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
        <div class="mb-5">
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Aksi cepat studio</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Akses cepat ke navigasi operasional studio Anda.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

            <!-- Cek Reservasi -->
            <button type="button" onclick="switchTab('reservasi')"
                class="group p-4 text-left border border-[#3b2230]/10 rounded-md hover:border-[#3b2230]/40 hover:bg-[#3b2230]/[0.03] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 mb-4 text-[#3b2230]/60 group-hover:text-[#3b2230] transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="block text-sm font-semibold">Cek reservasi</span>
                <span class="block mt-0.5 text-xs text-[#3b2230]/55">{{ $pendingCount }} perlu respon</span>
            </button>

            <!-- Tarik Saldo -->
            <button type="button" onclick="switchTab('saldo')"
                class="group p-4 text-left border border-[#3b2230]/10 rounded-md hover:border-[#3b2230]/40 hover:bg-[#3b2230]/[0.03] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 mb-4 text-[#3b2230]/60 group-hover:text-[#3b2230] transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="block text-sm font-semibold">Tarik saldo</span>
                <span class="block mt-0.5 text-xs text-[#3b2230]/55">Ajukan payout</span>
            </button>

            <!-- Paket Rias -->
            <button type="button" onclick="switchTab('paket')"
                class="group p-4 text-left border border-[#3b2230]/10 rounded-md hover:border-[#3b2230]/40 hover:bg-[#3b2230]/[0.03] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 mb-4 text-[#3b2230]/60 group-hover:text-[#3b2230] transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="block text-sm font-semibold">Paket rias</span>
                <span class="block mt-0.5 text-xs text-[#3b2230]/55">Kelola harga &amp; durasi</span>
            </button>

            <!-- Profil & Portofolio -->
            <button type="button" onclick="switchTab('profil')"
                class="group p-4 text-left border border-[#3b2230]/10 rounded-md hover:border-[#3b2230]/40 hover:bg-[#3b2230]/[0.03] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                <svg class="w-5 h-5 mb-4 text-[#3b2230]/60 group-hover:text-[#3b2230] transition-colors" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="block text-sm font-semibold">Profil &amp; portofolio</span>
                <span class="block mt-0.5 text-xs text-[#3b2230]/55">Data &amp; upload foto</span>
            </button>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Portofolio -->
        <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="flex items-baseline justify-between gap-4 mb-5">
                <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Portofolio saya</h2>
                <button type="button" onclick="switchTab('profil')"
                    class="text-sm text-[#3b2230]/60 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/25 hover:decoration-[#3b2230] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40 rounded-sm">
                    Detail
                </button>
            </div>

            @if($portfolios->isNotEmpty())
                <div class="grid grid-cols-2 gap-3">
                    @foreach($portfolios->take(4) as $item)
                        <div class="aspect-[4/5] overflow-hidden rounded-md bg-[#3b2230]/[0.07]">
                            <img src="{{ Storage::url($item->image_url) }}" alt="Foto portofolio" loading="lazy" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center border border-dashed border-[#3b2230]/20 rounded-md">
                    <p class="text-sm text-[#3b2230]/60">Belum ada foto portofolio.</p>
                    <button type="button" onclick="switchTab('profil')" class="mt-2 text-sm font-medium underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230]">Tambah foto di profil</button>
                </div>
            @endif
        </section>

        <!-- Ulasan -->
        <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="flex items-baseline justify-between gap-4 mb-2">
                <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Ulasan saya</h2>
                <span class="text-sm text-[#3b2230]/60">{{ $reviewsCount }} ulasan</span>
            </div>

            @forelse($reviews->take(3) as $review)
                <article class="py-5 border-b border-[#3b2230]/10 last:border-b-0">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="text-sm font-semibold truncate">{{ $review->client->name ?? 'Klien' }}</h3>
                        <span class="shrink-0 text-sm tracking-wider" aria-label="Rating {{ $review->rating }} dari 5">
                            {{ str_repeat('★', (int) $review->rating) }}<span class="text-[#3b2230]/25">{{ str_repeat('★', 5 - (int) $review->rating) }}</span>
                        </span>
                    </div>
                    <p class="mt-2 text-sm leading-relaxed text-[#3b2230]/80">{{ $review->comment }}</p>
                    <p class="mt-2 text-xs text-[#3b2230]/50">{{ $review->created_at->diffForHumans() }}</p>
                </article>
            @empty
                <p class="py-12 text-center text-sm text-[#3b2230]/60">Belum ada ulasan dari klien.</p>
            @endforelse
        </section>
    </div>
</div>