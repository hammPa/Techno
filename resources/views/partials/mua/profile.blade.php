{{--
    partials/mua/profile.blade.php
    Desain disamakan dengan overview.blade.php. Variabel: $profile, $portfolios (dipakai partial portofolio).
--}}
@php
    $inputClass = 'w-full px-3 py-2 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/40';
    $labelClass = 'block mb-1 text-xs font-medium text-[#3b2230]/70';
@endphp

<div class="space-y-6">

    <!-- Profil studio -->
    <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
        <div class="mb-5">
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Profil studio</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Informasi ini tampil di halaman Anda untuk calon klien.</p>
        </div>

        <form action="{{ route('mua.profile.update') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @csrf
            <div>
                <label for="pr-studio" class="{{ $labelClass }}">Nama studio / brand</label>
                <input id="pr-studio" type="text" name="studio_name" value="{{ old('studio_name', $profile->studio_name) }}" required class="{{ $inputClass }}">
            </div>
            <div>
                <label for="pr-city" class="{{ $labelClass }}">Kota domisili</label>
                <input id="pr-city" type="text" name="city" value="{{ old('city', $profile->city) }}" required class="{{ $inputClass }}">
            </div>
            <div>
                <label for="pr-ig" class="{{ $labelClass }}">Username Instagram</label>
                <input id="pr-ig" type="text" name="instagram_username" value="{{ old('instagram_username', $profile->instagram_username) }}" placeholder="Tanpa tanda @" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-3">
                <label for="pr-bio" class="{{ $labelClass }}">Bio / keahlian</label>
                <input id="pr-bio" type="text" name="bio" value="{{ old('bio', $profile->bio) }}" placeholder="Spesialisasi riasan wisuda glowing, adat Minang, bridal modern, dll." class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-3 flex justify-end pt-2">
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                    Simpan profil
                </button>
            </div>
        </form>
    </section>

    <!-- Portofolio -->
    @include('partials.mua.portfolios')

    <!-- Akun -->
    <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Akun</h2>
                <p class="mt-1 text-sm text-[#3b2230]/60">Keluar dari akun GlowMUA Anda. Anda bisa masuk kembali kapan saja.</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-[#3b2230] border border-[#3b2230]/25 hover:border-[#3b2230]/60 hover:bg-[#3b2230]/[0.04] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                    Keluar dari akun
                </button>
            </form>
        </div>
    </section>
</div>