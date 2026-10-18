@php
    $statusMap = [
        'completed' => ['Selesai',  'bg-emerald-50 text-emerald-800'],
        'pending'   => ['Menunggu', 'bg-amber-50 text-amber-800'],
        'rejected'  => ['Ditolak',  'bg-red-50 text-red-800'],
    ];
@endphp

<section class="bg-white border border-[#3b2230]/10 rounded-lg overflow-hidden">
    <div class="p-6 flex items-baseline justify-between gap-4 border-b border-[#3b2230]/10">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Penarikan saldo mitra</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Transfer dana ke rekening MUA, lalu unggah bukti transfer untuk menyelesaikan pencairan.</p>
        </div>
        <span class="shrink-0 text-sm text-[#3b2230]/60">{{ $payouts->where('status', 'pending')->count() }} menunggu transfer</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs text-[#3b2230]/60 bg-[#3b2230]/[0.04] border-b border-[#3b2230]/10">
                <tr>
                    <th scope="col" class="px-4 py-3 font-medium">Tanggal</th>
                    <th scope="col" class="px-4 py-3 font-medium">Mitra MUA</th>
                    <th scope="col" class="px-4 py-3 font-medium">Nominal tarik</th>
                    <th scope="col" class="px-4 py-3 font-medium">Rekening tujuan</th>
                    <th scope="col" class="px-4 py-3 font-medium">Status</th>
                    <th scope="col" class="px-4 py-3 font-medium text-right">Aksi admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#3b2230]/10">
                @forelse($payouts as $po)
                    @php [$stText, $stClass] = $statusMap[$po->status] ?? [$po->status, 'bg-[#3b2230]/[0.07] text-[#3b2230]/70']; @endphp
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-[#3b2230]/60">{{ $po->created_at->format('d M Y H:i') }} WIB</td>
                        <td class="px-4 py-3">
                            <span class="block font-semibold">{{ $po->user->name }}</span>
                            <span class="block text-xs text-[#3b2230]/55">{{ $po->user->email }} ({{ $po->user->phone }})</span>
                        </td>
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">Rp {{ number_format($po->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span class="block font-medium">{{ $po->bank_name }} &ndash; {{ $po->account_number }}</span>
                            <span class="block text-xs text-[#3b2230]/55">a/n {{ $po->account_holder }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-sm {{ $stClass }}">{{ $stText }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($po->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.payouts.approve', $po->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2"
                                          onsubmit="return confirm('Konfirmasi bahwa dana sudah ditransfer ke rekening MUA?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="file" name="proof_image" accept="image/*" required aria-label="Bukti transfer"
                                            class="w-44 text-xs text-[#3b2230]/60 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#3b2230]/[0.08] file:text-[#3b2230] hover:file:bg-[#3b2230]/[0.14] file:cursor-pointer">
                                        <button type="submit" class="px-3 py-1.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">Konfirmasi kirim</button>
                                    </form>

                                    <form action="{{ route('admin.payouts.reject', $po->id) }}" method="POST"
                                          onsubmit="const r = prompt('Alasan penolakan pencairan:'); if(!r) return false; this.querySelector('input[name=admin_notes]').value = r; return true;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="admin_notes" value="">
                                        <button type="submit" class="px-3 py-1.5 text-sm font-semibold text-red-700 border border-red-200 hover:bg-red-50 rounded-md whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700/40">Tolak</button>
                                    </form>
                                </div>
                            @elseif($po->status === 'completed' && $po->proof_image)
                                <a href="{{ Storage::url($po->proof_image) }}" target="_blank" rel="noopener"
                                   class="text-sm text-[#3b2230]/70 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                                    Lihat bukti transfer
                                </a>
                            @elseif($po->status === 'rejected')
                                <span class="text-xs text-[#3b2230]/60">Alasan: {{ $po->admin_notes }}</span>
                            @else
                                <span class="text-[#3b2230]/40">&ndash;</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-[#3b2230]/60">Belum ada pengajuan pencairan saldo dari mitra MUA.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>