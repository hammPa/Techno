<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-sm sm:text-base text-slate-900">Verifikasi Bukti Transfer Manual</h2>
            <p class="text-[11px] text-slate-400">Pastikan saldo sudah masuk ke mutasi rekening platform sebelum disetujui</p>
        </div>
        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200">
            {{ $payments->where('status', 'pending')->count() }} Pending
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-[10px] font-bold">
                <tr>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Klien & MUA</th>
                    <th class="p-4">Tipe & Nominal</th>
                    <th class="p-4">Info Pengirim</th>
                    <th class="p-4 text-center">Bukti Transfer</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $pm)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4 text-slate-500 whitespace-nowrap">
                            {{ $pm->created_at->format('d M Y H:i') }} WIB
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-900">{{ $pm->user->name }}</div>
                            <div class="text-[11px] text-slate-400">
                                MUA: {{ $pm->booking->mua->name }} ({{ $pm->booking->service->title }})
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $pm->type === 'full' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $pm->type }}
                            </span>
                            <div class="font-extrabold text-slate-900 mt-1">
                                Rp {{ number_format($pm->amount, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-slate-700">{{ $pm->sender_name }}</div>
                            <div class="text-[11px] text-slate-400">Via: {{ $pm->bank_name }}</div>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ asset('storage/' . $pm->proof_image) }}" target="_blank" class="inline-block group relative">
                                <img src="{{ asset('storage/' . $pm->proof_image) }}" alt="Bukti Transfer" class="w-12 h-12 rounded-lg object-cover border border-slate-200 group-hover:scale-105 transition shadow-xs mx-auto">
                                <span class="block text-[9px] text-rose-600 mt-0.5 underline">Lihat Foto</span>
                            </a>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                {{ $pm->status === 'verified' ? 'bg-emerald-100 text-emerald-800' : ($pm->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                {{ $pm->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            @if($pm->status === 'pending')
                                <form action="{{ route('admin.payments.verify', $pm->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa pembayaran ini sudah valid masuk rekening?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs transition">
                                        ✓ Setujui
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-400 text-xs italic">Selesai Diverifikasi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">Belum ada transaksi pembayaran yang dikirimkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>