<div class="bg-white rounded-3xl border border-rose-100 p-5 sm:p-6 shadow-sm mb-8">
    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
        <div>
            <h2 class="font-bold text-base text-slate-900">Dompet Mitra & Penarikan Saldo (Payout)</h2>
            <p class="text-xs text-slate-400">Tarik hasil pendapatan jasa riasan Anda langsung ke rekening bank pribadi</p>
        </div>
        <span class="text-xs font-bold px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
            Tersedia: Rp {{ number_format($user->available_balance, 0, ',', '.') }}
        </span>
    </div>

    <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80 mb-6">
        <h3 class="text-xs font-bold text-slate-800 uppercase mb-3">Form Pengajuan Penarikan Dana</h3>
        <form action="{{ route('mua.payouts.store') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nominal Tarik (Rp)</label>
                    <input type="number" name="amount" min="50000" max="{{ $user->available_balance }}" 
                        placeholder="Min. 50000" required
                        class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bank / E-Wallet Tujuan</label>
                    <input type="text" name="bank_name" placeholder="Misal: BCA, Mandiri, Seabank" required
                        class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nomor Rekening</label>
                    <input type="text" name="account_number" placeholder="Nomor rekening tujuan" required
                        class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Atas Nama Rekening</label>
                    <input type="text" name="account_holder" placeholder="Nama pemilik rekening" required
                        class="w-full px-3 py-2 bg-white rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-rose-500">
                </div>
            </div>

            <div class="text-right pt-2">
                <button type="submit" 
                    @if($user->available_balance < 50000) disabled @endif
                    class="px-5 py-2 rounded-xl text-xs font-semibold transition shadow-xs {{ $user->available_balance < 50000 ? 'bg-slate-300 text-slate-500 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }}">
                    Ajukan Penarikan Dana
                </button>
            </div>
        </form>
    </div>

    <h3 class="text-xs font-bold text-slate-800 uppercase mb-2">Riwayat Pengajuan Pencairan</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200">
                <tr>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Nominal</th>
                    <th class="p-3">Tujuan Transfer</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Bukti Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($myPayouts as $py)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-3 text-slate-500 whitespace-nowrap">{{ $py->created_at->format('d M Y H:i') }}</td>
                        <td class="p-3 font-bold text-slate-900">Rp {{ number_format($py->amount, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="font-medium text-slate-800">{{ $py->bank_name }} - {{ $py->account_number }}</span>
                            <span class="block text-[11px] text-slate-400">a/n {{ $py->account_holder }}</span>
                        </td>
                        <td class="p-3 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                                {{ $py->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($py->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                {{ $py->status }}
                            </span>
                            @if($py->status === 'rejected' && $py->admin_notes)
                                <span class="block text-[10px] text-rose-600 italic mt-0.5">{{ $py->admin_notes }}</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if($py->proof_image)
                                <a href="{{ Storage::url($py->proof_image) }}" target="_blank" class="text-rose-600 underline font-semibold text-[11px]">
                                    Lihat Struk
                                </a>
                            @else
                                <span class="text-slate-400 text-[11px]">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-slate-400">Belum pernah mengajukan penarikan dana.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>