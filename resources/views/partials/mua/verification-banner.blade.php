@php
    $verifStatus = $profile->verification_status ?? 'unverified';
@endphp

@if($verifStatus === 'verified')
    <div class="mb-6 p-4 bg-emerald-50/90 border border-emerald-200 rounded-2xl flex items-center gap-3 shadow-xs">
        <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm font-bold shrink-0">✓</span>
        <div>
            <h4 class="text-xs font-bold text-emerald-900">Akun Terverifikasi</h4>
            <p class="text-[11px] text-emerald-700 mt-0.5">Identitas KTP kamu telah disetujui. Layanan dan tokomu sekarang aktif dan tampil di halaman utama.</p>
        </div>
    </div>
@elseif($verifStatus === 'pending')
    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start sm:items-center gap-3 shadow-xs">
        <span class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm font-bold shrink-0">⏳</span>
        <div class="flex-1">
            <h4 class="text-xs font-bold text-amber-900">KTP Sedang Diverifikasi Admin</h4>
            <p class="text-[11px] text-amber-700 mt-0.5">Dokumen identitasmu sedang dalam antrean pemeriksaan. Selama proses ini, profil tokomu belum muncul di landing page.</p>
        </div>
    </div>
@else
    <div class="mb-6 p-5 bg-white border {{ $verifStatus === 'rejected' ? 'border-rose-300 ring-2 ring-rose-100' : 'border-slate-200' }} rounded-2xl shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl {{ $verifStatus === 'rejected' ? 'bg-rose-100 text-rose-600' : 'bg-slate-900 text-white' }} flex items-center justify-center text-sm font-bold shrink-0">🪪</span>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">
                        {{ $verifStatus === 'rejected' ? 'Verifikasi Ditolak - Silakan Unggah Ulang' : 'Wajib Verifikasi KTP / Identitas' }}
                    </h4>
                    <p class="text-[11px] text-slate-500">Klien hanya dapat melihat dan memesan MUA yang telah lolos verifikasi identitas resmi.</p>
                </div>
            </div>
            <span class="self-start sm:self-auto px-2 py-0.5 text-[10px] font-bold rounded-md uppercase tracking-wider {{ $verifStatus === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600' }}">
                {{ $verifStatus }}
            </span>
        </div>

        @if($verifStatus === 'rejected' && $profile->rejection_reason)
            <div class="mt-3 p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 flex items-start gap-2">
                <span class="font-bold shrink-0">Alasan Penolakan:</span>
                <span>{{ $profile->rejection_reason }}</span>
            </div>
        @endif

        <form action="{{ route('mua.identity.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4 flex flex-col sm:flex-row sm:items-center gap-3">
            @csrf
            <div class="flex-1">
                <input type="file" name="id_card" accept="image/jpeg,image/png,image/webp" required
                    class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50">
                <span class="text-[10px] text-slate-400 mt-1 block">Format gambar: JPG, PNG, atau WEBP. Maks 3MB. Pastikan foto dan NIK terbaca jelas.</span>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition shadow-xs whitespace-nowrap self-end sm:self-auto">
                Kirim KTP
            </button>
        </form>
    </div>
@endif