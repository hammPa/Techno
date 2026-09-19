<div class="space-y-6">
    <!-- Form Profil Studio MUA -->
    <div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm">
        <h2 class="font-bold text-base text-slate-900 mb-3">Pengaturan Profil Studio</h2>
        <form action="{{ route('mua.profile.update') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Studio / Brand</label>
                <input type="text" name="studio_name" value="{{ old('studio_name', $profile->studio_name) }}" required
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kota Domisili</label>
                <input type="text" name="city" value="{{ old('city', $profile->city) }}" required
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Username Instagram</label>
                <input type="text" name="instagram_username" value="{{ old('instagram_username', $profile->instagram_username) }}" placeholder="tanpa tanda @"
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
            </div>
            <div class="sm:col-span-3">
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bio / Keahlian</label>
                <input type="text" name="bio" value="{{ old('bio', $profile->bio) }}" placeholder="Spesialisasi riasan wisuda glowing, adat Minang, bridal modern, dll."
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-rose-500">
            </div>
            <div class="sm:col-span-3 text-right">
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Kelola Portofolio Foto -->
    @include('partials.mua.portfolios')
</div>