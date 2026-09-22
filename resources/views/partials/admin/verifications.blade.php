<div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-xs">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-900">Antrean Verifikasi KTP MUA</h2>
        <p class="text-xs text-slate-500">Tinjau foto identitas mitra MUA. Setelah disetujui, toko MUA akan otomatis tampil di katalog landing page.</p>
    </div>

    @php
        $pendingMuas = $muaUsers->filter(fn($u) => optional($u->muaProfile)->verification_status === 'pending');
    @endphp

    @if($pendingMuas->isEmpty())
        <div class="text-center py-12">
            <span class="text-4xl block mb-2">🎉</span>
            <p class="text-xs font-semibold text-slate-700">Tidak ada pengajuan verifikasi KTP yang menunggu.</p>
            <p class="text-[11px] text-slate-400 mt-1">Semua dokumen MUA telah diverifikasi atau belum ada yang mengajukan.</p>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach($pendingMuas as $mua)
                @php $prof = $mua->muaProfile; @endphp
                <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-xs font-bold text-slate-900">{{ $prof->studio_name ?? $mua->name }}</h3>
                            <span class="text-[10px] px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md font-semibold">Menunggu Verifikasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500">
                            Pemilik: <span class="font-medium text-slate-700">{{ $mua->name }}</span> • 
                            Email: <span class="font-medium text-slate-700">{{ $mua->email }}</span> • 
                            Kota: <span class="font-medium text-slate-700">{{ $prof->city ?? '-' }}</span>
                        </p>
                        
                        @if($prof->id_card_url)
                            <div class="pt-1">
                                <a href="{{ Storage::url($prof->id_card_url) }}" target="_blank" rel="noopener noreferrer" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl text-xs font-semibold transition">
                                    🔍 Buka Foto KTP (Tab Baru)
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 self-end md:self-auto">
                        <!-- Form Setujui -->
                        <form action="{{ route('admin.mua.verify', $prof) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Setujui identitas {{ $prof->studio_name ?? $mua->name }}? Toko akan langsung aktif di halaman utama.')" 
                                class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition shadow-xs">
                                ✓ Setujui
                            </button>
                        </form>

                        <!-- Tombol Buka Modal Tolak -->
                        <button type="button" onclick="openRejectModal('{{ $prof->id }}', '{{ addslashes($prof->studio_name ?? $mua->name) }}')" 
                            class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-semibold transition">
                            ✕ Tolak
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>