
<section id="pricing" class="relative overflow-hidden bg-white py-20 sm:py-28">
    <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-[#3b2230]/[0.04] blur-3xl"></div>
    <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-[#3b2230]/[0.04] blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Heading --}}
        <div class="mx-auto mb-16 max-w-2xl text-center">
            <span class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#3b2230]/10 bg-[#3b2230]/[0.04] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#3b2230]/70">
                <span class="h-1.5 w-1.5 rounded-full bg-[#3b2230]"></span>
                Pricing & Plans
            </span>

            <h2 class="font-['Fraunces'] text-4xl font-semibold leading-tight tracking-tight text-[#3b2230] sm:text-5xl">
                Sederhana, transparan,<br>
                <span class="italic text-[#9b7182]">tanpa biaya tersembunyi.</span>
            </h2>

            <p class="mx-auto mt-5 max-w-xl text-sm leading-7 text-[#3b2230]/60 sm:text-base">
                Temukan MUA impianmu atau kembangkan bisnis makeup-mu.
                Pilih paket yang sesuai dengan kebutuhanmu.
            </p>
        </div>

        {{-- Pricing Cards --}}
        <div class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-3 lg:items-stretch">

            {{-- Client --}}
            <div class="flex flex-col rounded-3xl border border-[#3b2230]/10 bg-[#faf8f9] p-8 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#3b2230]/5">

                <div class="mb-6">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#3b2230]/[0.07] text-[#3b2230]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M12 7a4 4 0 11-8 0 4 4 0 018 0zm8 4a4 4 0 10-3-6.87"/>
                        </svg>
                    </div>

                    <h3 class="font-['Fraunces'] text-2xl font-semibold text-[#3b2230]">
                        Client
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#3b2230]/55">
                        Untuk kamu yang ingin menemukan dan memesan jasa makeup artist.
                    </p>
                </div>

                <div class="mb-8">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-semibold tracking-tight text-[#3b2230]">Gratis</span>
                    </div>
                    <p class="mt-2 text-xs text-[#3b2230]/50">Selamanya, tanpa langganan.</p>
                </div>

                <div class="mb-8 flex-1 space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#3b2230]/40">
                        Yang kamu dapatkan
                    </p>

                    @foreach ([
                        'Jelajahi direktori MUA',
                        'Lihat profil dan portofolio MUA',
                        'Akses informasi layanan dan harga',
                        'Melakukan reservasi secara online',
                        'Pantau status booking',
                        'Berikan ulasan setelah layanan'
                    ] as $feature)
                        <div class="flex items-start gap-3 text-sm text-[#3b2230]/75">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#947080]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('register') }}"
                   class="block rounded-xl border border-[#3b2230]/20 px-5 py-3.5 text-center text-sm font-semibold text-[#3b2230] transition hover:bg-[#3b2230] hover:text-white">
                    Mulai Sekarang
                </a>
            </div>


            {{-- MUA Starter --}}
            <div class="relative flex flex-col rounded-3xl border-2 border-[#3b2230] bg-white p-8 shadow-2xl shadow-[#3b2230]/10 transition duration-300 hover:-translate-y-1">

                <div class="absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-[#3b2230] px-5 py-2 text-xs font-semibold tracking-wide text-white shadow-lg">
                    Pilihan Terbaik
                </div>

                <div class="mb-6">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#3b2230] text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3l2.5 5.5L20 11l-5.5 2.5L12 19l-2.5-5.5L4 11l5.5-2.5L12 3z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 14l1.5 3.5L24 19l-3.5 1.5L19 24l-1.5-3.5L14 19l3.5-1.5L19 14z"/>
                        </svg>
                    </div>

                    <h3 class="font-['Fraunces'] text-2xl font-semibold text-[#3b2230]">
                        MUA Starter
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#3b2230]/55">
                        Mulai bangun bisnis makeup dan jangkau lebih banyak calon pelanggan.
                    </p>
                </div>

                <div class="mb-8">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-semibold tracking-tight text-[#3b2230]">Rp0</span>
                        <span class="text-sm text-[#3b2230]/50">/bulan</span>
                    </div>

                    <p class="mt-2 text-xs font-medium text-[#947080]">
                        Hanya dikenakan komisi saat booking berhasil.
                    </p>

                    <div class="mt-4 rounded-xl bg-[#3b2230]/[0.05] p-4">
                        <p class="text-xs text-[#3b2230]/60">Komisi per booking selesai</p>
                        <p class="mt-1 text-2xl font-bold text-[#3b2230]">5%</p>
                    </div>
                </div>

                <div class="mb-8 flex-1 space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#3b2230]/40">
                        Semua fitur Client, ditambah
                    </p>

                    @foreach ([
                        'Buat dan kelola profil MUA',
                        'Tambahkan layanan dan harga',
                        'Unggah portofolio makeup',
                        'Kelola jadwal ketersediaan',
                        'Terima dan kelola booking',
                        'Kelola status pesanan',
                        'Ajukan pencairan pendapatan'
                    ] as $feature)
                        <div class="flex items-start gap-3 text-sm text-[#3b2230]/75">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#947080]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('register') }}"
                   class="block rounded-xl bg-[#3b2230] px-5 py-3.5 text-center text-sm font-semibold text-white shadow-lg shadow-[#3b2230]/20 transition hover:bg-[#563346]">
                    Daftar sebagai MUA
                </a>
            </div>


            {{-- MUA Pro --}}
            <div class="flex flex-col rounded-3xl border border-[#3b2230]/10 bg-[#faf8f9] p-8 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#3b2230]/5">

                <div class="mb-6">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#3b2230]/[0.07] text-[#3b2230]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3l2.5 5.5L20 11l-5.5 2.5L12 19l-2.5-5.5L4 11l5.5-2.5L12 3z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 21h14"/>
                        </svg>
                    </div>

                    <h3 class="font-['Fraunces'] text-2xl font-semibold text-[#3b2230]">
                        MUA Pro
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#3b2230]/55">
                        Untuk MUA yang ingin mengembangkan bisnis dan meningkatkan visibilitas.
                    </p>
                </div>

                <div class="mb-8">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-semibold tracking-tight text-[#3b2230]">Rp49.000</span>
                        <span class="text-sm text-[#3b2230]/50">/bulan</span>
                    </div>

                    <p class="mt-2 text-xs font-medium text-[#947080]">
                        Langganan opsional, dapat dibatalkan.
                    </p>

                    <div class="mt-4 rounded-xl bg-[#3b2230]/[0.05] p-4">
                        <p class="text-xs text-[#3b2230]/60">Komisi per booking selesai</p>
                        <p class="mt-1 text-2xl font-bold text-[#3b2230]">3%</p>
                        <p class="mt-1 text-xs text-[#3b2230]/50">Lebih hemat dibanding Starter.</p>
                    </div>
                </div>

                <div class="mb-8 flex-1 space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#3b2230]/40">
                        Semua fitur Starter, ditambah
                    </p>

                    @foreach ([
                        'Prioritas tampil di direktori MUA',
                        'Statistik kunjungan profil',
                        'Statistik performa booking',
                        'Promosi profil dan portofolio',
                        'Insight perkembangan bisnis'
                    ] as $feature)
                        <div class="flex items-start gap-3 text-sm text-[#3b2230]/75">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#947080]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('register') }}"
                   class="block rounded-xl border border-[#3b2230]/20 px-5 py-3.5 text-center text-sm font-semibold text-[#3b2230] transition hover:bg-[#3b2230] hover:text-white">
                    Gabung sebagai MUA
                </a>
            </div>

        </div>

        {{-- Additional Information --}}
        <div class="mx-auto mt-12 max-w-3xl rounded-2xl border border-[#3b2230]/10 bg-[#faf8f9] p-6 sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#3b2230]/[0.07] text-[#3b2230]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.7 3h16.96a2 2 0 001.7-3L13.7 3.86a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>

                <div>
                    <h4 class="font-semibold text-[#3b2230]">
                        Bagaimana sistem komisi bekerja?
                    </h4>
                    <p class="mt-2 text-sm leading-7 text-[#3b2230]/60">
                        Komisi hanya dikenakan pada booking yang telah berhasil diselesaikan.
                        Tidak ada biaya pendaftaran, biaya bulanan untuk paket Starter,
                        ataupun potongan ketika MUA belum mendapatkan pesanan.
                    </p>
                </div>
            </div>
        </div>

        {{-- Bottom CTA --}}
        <div class="mt-16 text-center">
            <p class="font-['Fraunces'] text-2xl text-[#3b2230]">
                Bisnis makeup-mu layak berkembang.
            </p>
            <p class="mt-2 text-sm text-[#3b2230]/55">
                Mulai perjalananmu bersama TemuMUA hari ini.
            </p>
            <a href="{{ route('register') }}"
               class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#3b2230] px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-[#563346]">
                Bergabung Sekarang
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6l6 6-6 6"/>
                </svg>
            </a>
        </div>

    </div>
</section>
