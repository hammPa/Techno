<section id="cara-kerja" class="bg-white py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="text-center text-3xl sm:text-4xl" style="font-family: 'Fraunces', serif;">
            Cara Kerjanya
        </h2>

        @php
            $steps = [
                ['Cari', 'Filter berdasarkan kota, jenis acara, dan budget.'],
                ['Bandingkan', 'Lihat portofolio, harga, dan ulasan beberapa MUA.'],
                ['Booking', 'Pilih tanggal dan paket, lalu kirim permintaan reservasi.'],
                ['Tampil Cantik', 'MUA konfirmasi, kamu tinggal datang atau menunggu di lokasi.'],
            ];
        @endphp

        <ol class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($steps as $i => [$title, $desc])
                <li class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#3b2230] text-xl font-semibold text-white">
                        {{ $i + 1 }}
                    </div>
                    <h3 class="mt-4 font-semibold">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-[#3b2230]/70">{{ $desc }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>