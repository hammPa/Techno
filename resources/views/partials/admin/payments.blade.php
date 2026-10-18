@php
    $statusMap = [
        'verified' => ['Terverifikasi', 'bg-emerald-50 text-emerald-800'],
        'pending'  => ['Menunggu',      'bg-amber-50 text-amber-800'],
        'rejected' => ['Ditolak',       'bg-red-50 text-red-800'],
    ];
@endphp

<section class="bg-white border border-[#3b2230]/10 rounded-lg overflow-hidden">
    <div class="p-6 flex items-baseline justify-between gap-4 border-b border-[#3b2230]/10">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Verifikasi bukti transfer</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Pastikan dana sudah masuk ke mutasi rekening platform sebelum disetujui.</p>
        </div>
        <span class="shrink-0 text-sm text-[#3b2230]/60">{{ $payments->where('status', 'pending')->count() }} menunggu</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs text-[#3b2230]/60 bg-[#3b2230]/[0.04] border-b border-[#3b2230]/10">
                <tr>
                    <th scope="col" class="px-4 py-3 font-medium">Tanggal</th>
                    <th scope="col" class="px-4 py-3 font-medium">Klien &amp; MUA</th>
                    <th scope="col" class="px-4 py-3 font-medium">Tipe &amp; nominal</th>
                    <th scope="col" class="px-4 py-3 font-medium">Info pengirim</th>
                    <th scope="col" class="px-4 py-3 font-medium">Bukti transfer</th>
                    <th scope="col" class="px-4 py-3 font-medium">Status</th>
                    <th scope="col" class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#3b2230]/10">
                @forelse($payments as $pm)
                    @php [$stText, $stClass] = $statusMap[$pm->status] ?? [$pm->status, 'bg-[#3b2230]/[0.07] text-[#3b2230]/70']; @endphp
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-[#3b2230]/60">{{ $pm->created_at->format('d M Y H:i') }} WIB</td>
                        <td class="px-4 py-3">
                            <span class="block font-semibold">{{ $pm->user->name }}</span>
                            <span class="block text-xs text-[#3b2230]/55">MUA: {{ $pm->booking->mua->name }} ({{ $pm->booking->service->title }})</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium capitalize rounded-sm {{ $pm->type === 'full' ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-800' }}">{{ $pm->type }}</span>
                            <span class="block mt-1 font-semibold">Rp {{ number_format($pm->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="block font-medium">{{ $pm->sender_name }}</span>
                            <span class="block text-xs text-[#3b2230]/55">Via {{ $pm->bank_name }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($pm->proof_image)
                                <a href="{{ Storage::url($pm->proof_image) }}" target="_blank" rel="noopener" class="inline-block rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                                    <img src="{{ Storage::url($pm->proof_image) }}" alt="Bukti transfer {{ $pm->user->name }}" loading="lazy" class="w-12 h-12 rounded-md object-cover border border-[#3b2230]/10">
                                    <span class="block mt-1 text-xs underline underline-offset-4 decoration-[#3b2230]/30 text-[#3b2230]/70">Lihat foto</span>
                                </a>
                            @else
                                <span class="text-xs text-[#3b2230]/45">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-sm {{ $stClass }}">{{ $stText }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($pm->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.payments.verify', $pm->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa dana transfer ini sudah valid dan masuk rekening?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">Setujui</button>
                                    </form>

                                    <form action="{{ route('admin.payments.reject', $pm->id) }}" method="POST"
                                          onsubmit="const reason = prompt('Masukkan alasan penolakan bukti transfer ini:'); if(!reason) return false; this.querySelector('input[name=admin_notes]').value = reason; return true;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="admin_notes" value="">
                                        <button type="submit" class="px-3 py-1.5 text-sm font-semibold text-red-700 border border-red-200 hover:bg-red-50 rounded-md whitespace-nowrap transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700/40">Tolak</button>
                                    </form>
                                </div>
                            @elseif($pm->status === 'rejected' && $pm->admin_notes)
                                <span class="text-xs text-[#3b2230]/60">Alasan: {{ $pm->admin_notes }}</span>
                            @else
                                <span class="text-[#3b2230]/40">&ndash;</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-[#3b2230]/60">Belum ada transaksi pembayaran yang dikirimkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>