<section id="kenapa" class="py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl sm:text-4xl" style="font-family: 'Fraunces', serif;">
                Kenapa pilih TemuMUA?
            </h2>
            <p class="mt-3 text-[#3b2230]/70">
                Cari makeup artist jadi lebih mudah, jelas, dan aman.
            </p>
        </div>

        @php
            $reasons = [
                [
                    'title' => 'Portofolio Terverifikasi',
                    'desc'  => 'Lihat hasil kerja asli MUA sebelum memutuskan, tanpa tebak-tebakan.',
                    'paths' => ['M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z'],
                ],
                [
                    'title' => 'Harga Transparan',
                    'desc'  => 'Daftar harga dan paket tampil jelas, tanpa biaya tersembunyi.',
                    'paths' => ['M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z'],
                ],
                [
                    'title' => 'Reservasi Mudah',
                    'desc'  => 'Cek jadwal kosong dan booking langsung dari satu tempat.',
                    'paths' => ['M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
                ],
                [
                    'title' => 'Cari Sesuai Lokasi',
                    'desc'  => 'Temukan MUA terdekat atau yang bersedia datang ke lokasimu.',
                    'paths' => [
                        'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
                        'M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z',
                    ],
                ],
                [
                    'title' => 'Ulasan Asli',
                    'desc'  => 'Rating dan review dari klien yang benar-benar sudah memakai jasanya.',
                    'paths' => ['M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z'],
                ],
                [
                    'title' => 'Chat Langsung',
                    'desc'  => 'Konsultasi tema, tone makeup, dan kebutuhan acara sebelum booking.',
                    'paths' => ['M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z'],
                ],
            ];
        @endphp

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($reasons as $r)
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#3b2230]/10 transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#3b2230]/5 text-[#3b2230]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-6 w-6" aria-hidden="true">
                            @foreach ($r['paths'] as $d)
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}" />
                            @endforeach
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">{{ $r['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#3b2230]/70">{{ $r['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>