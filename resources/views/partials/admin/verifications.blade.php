@php
    $pendingMuas = $muaUsers->filter(fn($u) => optional($u->muaProfile)->verification_status === 'pending');
@endphp

<section class="bg-white border border-[#3b2230]/10 rounded-lg p-6 sm:p-7">
    <div class="mb-5">
        <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Antrean verifikasi KTP MUA</h2>
        <p class="mt-1 text-sm text-[#3b2230]/60">Tinjau foto identitas mitra MUA. Setelah disetujui, toko MUA otomatis tampil di katalog halaman utama.</p>
    </div>

    @if($pendingMuas->isEmpty())
        <div class="py-12 text-center border border-dashed border-[#3b2230]/20 rounded-md">
            <p class="text-sm font-medium">Tidak ada pengajuan verifikasi KTP yang menunggu.</p>
            <p class="mt-1 text-sm text-[#3b2230]/60">Semua dokumen MUA sudah diverifikasi, atau belum ada yang mengajukan.</p>
        </div>
    @else
        <div class="border border-[#3b2230]/10 rounded-md divide-y divide-[#3b2230]/10">
            @foreach($pendingMuas as $mua)
                @php
                    $prof        = $mua->muaProfile;
                    $displayName = $prof->studio_name ?? $mua->name;
                    $confirmMsg  = 'Setujui identitas ' . $displayName . '? Toko akan langsung aktif di halaman utama.';
                @endphp
                <div class="p-4 sm:px-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="min-w-0 space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-sm font-semibold">{{ $displayName }}</h3>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-sm bg-amber-50 text-amber-800">Menunggu verifikasi</span>
                        </div>
                        <dl class="flex flex-wrap gap-x-5 gap-y-1 text-sm text-[#3b2230]/60">
                            <div class="flex gap-1"><dt>Pemilik:</dt><dd class="font-medium text-[#3b2230]/80">{{ $mua->name }}</dd></div>
                            <div class="flex gap-1"><dt>Email:</dt><dd class="font-medium text-[#3b2230]/80">{{ $mua->email }}</dd></div>
                            <div class="flex gap-1"><dt>Kota:</dt><dd class="font-medium text-[#3b2230]/80">{{ $prof->city ?? '-' }}</dd></div>
                        </dl>

                        @if($prof->id_card_url)
                            <a href="{{ Storage::url($prof->id_card_url) }}" target="_blank" rel="noopener noreferrer"
                               class="inline-block text-sm text-[#3b2230]/70 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                                Buka foto KTP (tab baru)
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 self-end md:self-auto shrink-0">
                        <form action="{{ route('admin.mua.verify', $prof) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm(@js($confirmMsg))"
                                class="px-3.5 py-2 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                                Setujui
                            </button>
                        </form>

                        <button type="button" onclick="openRejectModal(@js($prof->id), @js($displayName))"
                            class="px-3.5 py-2 text-sm font-semibold text-red-700 border border-red-200 hover:bg-red-50 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700/40">
                            Tolak
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>