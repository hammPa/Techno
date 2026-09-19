<div>
    <!-- Kartu Metrik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
        <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl text-lg">⏳</div>
            <div>
                <span class="text-[11px] text-slate-400 font-medium">Permintaan Baru</span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $bookings->where('status', 'pending')->count() }} Booking</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl text-lg">💄</div>
            <div>
                <span class="text-[11px] text-slate-400 font-medium">Paket Rias Aktif</span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $services->count() }} Paket</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl text-lg">💰</div>
            <div>
                <span class="text-[11px] text-slate-400 font-medium">Saldo Aktif Dapat Ditarik</span>
                <h3 class="text-base sm:text-lg font-bold text-emerald-600">
                    Rp {{ number_format($user->available_balance, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Card -->
    <div class="bg-white rounded-3xl border border-rose-100 p-6 shadow-sm">
        <h2 class="font-bold text-base text-slate-900 mb-2">Aksi Cepat Studio</h2>
        <p class="text-xs text-slate-500 mb-5">Pilih menu navigasi di bawah untuk langsung menuju pengaturan operasional studio:</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <button type="button" onclick="switchTab('reservasi')" class="p-4 rounded-2xl bg-rose-50/50 hover:bg-rose-100/70 border border-rose-100 text-left transition group">
                <span class="text-2xl block mb-2">📅</span>
                <span class="text-xs font-bold text-slate-800 block group-hover:text-rose-600">Cek Reservasi</span>
                <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $bookings->where('status', 'pending')->count() }} perlu respon</span>
            </button>
            <button type="button" onclick="switchTab('saldo')" class="p-4 rounded-2xl bg-rose-50/50 hover:bg-rose-100/70 border border-rose-100 text-left transition group">
                <span class="text-2xl block mb-2">💸</span>
                <span class="text-xs font-bold text-slate-800 block group-hover:text-rose-600">Tarik Saldo</span>
                <span class="text-[10px] text-slate-400 mt-0.5 block">Ajukan payout</span>
            </button>
            <button type="button" onclick="switchTab('paket')" class="p-4 rounded-2xl bg-rose-50/50 hover:bg-rose-100/70 border border-rose-100 text-left transition group">
                <span class="text-2xl block mb-2">💄</span>
                <span class="text-xs font-bold text-slate-800 block group-hover:text-rose-600">Paket Rias</span>
                <span class="text-[10px] text-slate-400 mt-0.5 block">Kelola harga & durasi</span>
            </button>
            <button type="button" onclick="switchTab('profil')" class="p-4 rounded-2xl bg-rose-50/50 hover:bg-rose-100/70 border border-rose-100 text-left transition group">
                <span class="text-2xl block mb-2">⚙️</span>
                <span class="text-xs font-bold text-slate-800 block group-hover:text-rose-600">Profil & Portofolio</span>
                <span class="text-[10px] text-slate-400 mt-0.5 block">Data & upload foto</span>
            </button>
        </div>
    </div>
</div>