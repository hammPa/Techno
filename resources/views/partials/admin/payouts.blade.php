<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-sm sm:text-base text-slate-900">Pengajuan Penarikan Saldo Mitra (Payout)</h2>
            <p class="text-[11px] text-slate-400">Transfer dana ke rekening MUA lalu unggah bukti transfer untuk menyelesaikan pencairan</p>
        </div>
        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200">
            {{ $payouts->where('status', 'pending')->count() }} Menunggu Transfer
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-[10px] font-bold">
                <tr>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Mitra MUA</th>
                    <th class="p-4">Nominal Tarik</th>
                    <th class="p-4">Rekening Tujuan</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payouts as $po)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4 text-slate-500 whitespace-nowrap">{{ $po->created_at->format('d M Y H:i') }} WIB</td>
                        <td class="p-4">
                            <div class="font-bold text-slate-900">{{ $po->user->name }}</div>
                            <div class="text-[11px] text-slate-400">{{ $po->user->email }} ({{ $po->user->phone }})</div>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-extrabold text-slate-900">
                                Rp {{ number_format($po->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-800">{{ $po->bank_name }} - {{ $po->account_number }}</div>
                            <div class="text-[11px] text-slate-500">a/n {{ $po->account_holder }}</div>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                {{ $po->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($po->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                {{ $po->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            @if($po->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.payouts.approve', $po->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-1.5"
                                          onsubmit="return confirm('Konfirmasi bahwa dana sudah ditransfer ke rekening MUA?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="file" name="proof_image" accept="image/*" required class="text-[10px] w-40 text-slate-500 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:bg-slate-800 file:text-white">
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs transition whitespace-nowrap">
                                            ✓ Konfirmasi Kirim
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.payouts.reject', $po->id) }}" method="POST"
                                          onsubmit="const r = prompt('Alasan penolakan pencairan:'); if(!r) return false; this.querySelector('input[name=admin_notes]').value = r; return true;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="admin_notes" value="">
                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-semibold transition">
                                            ✕ Tolak
                                        </button>
                                    </form>
                                </div>
                            @elseif($po->status === 'completed')
                                <a href="{{ asset('storage/' . $po->proof_image) }}" target="_blank" class="text-rose-600 underline font-medium text-xs">
                                    Lihat Bukti Transfer
                                </a>
                            @else
                                <span class="text-slate-400 text-xs italic">Ditolak: "{{ $po->admin_notes }}"</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">Belum ada pengajuan pencairan saldo dari mitra MUA.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>