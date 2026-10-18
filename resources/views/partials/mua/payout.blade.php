@php
    $canWithdraw = $user->available_balance >= 50000;
    $statusLabels = [
        'completed' => ['Selesai',   'bg-emerald-50 text-emerald-800'],
        'pending'   => ['Menunggu',  'bg-amber-50 text-amber-800'],
        'rejected'  => ['Ditolak',   'bg-red-50 text-red-800'],
    ];
    $inputClass = 'w-full px-3 py-2 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/40';
    $labelClass = 'block mb-1 text-xs font-medium text-[#3b2230]/70';
@endphp

<section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg mb-6">
    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2 mb-5">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Saldo &amp; penarikan</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Tarik pendapatan jasa rias ke rekening bank pribadi Anda.</p>
        </div>
        <div class="sm:text-right">
            <span class="block text-xs text-[#3b2230]/55">Saldo dapat ditarik</span>
            <span class="block text-lg font-semibold">Rp {{ number_format($user->available_balance, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Form penarikan -->
    <form action="{{ route('mua.payouts.store') }}" method="POST" class="p-4 mb-8 space-y-3 border border-[#3b2230]/10 rounded-md bg-[#3b2230]/[0.03]">
        @csrf
        <h3 class="text-sm font-semibold">Ajukan penarikan dana</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label for="po-amount" class="{{ $labelClass }}">Nominal (Rp)</label>
                <input id="po-amount" type="number" name="amount" min="50000" max="{{ $user->available_balance }}"
                    placeholder="Minimal 50000" required class="{{ $inputClass }}">
            </div>
            <div>
                <label for="po-bank" class="{{ $labelClass }}">Bank / e-wallet tujuan</label>
                <input id="po-bank" type="text" name="bank_name" placeholder="BCA, Mandiri, Seabank" required class="{{ $inputClass }}">
            </div>
            <div>
                <label for="po-account" class="{{ $labelClass }}">Nomor rekening</label>
                <input id="po-account" type="text" name="account_number" placeholder="Nomor rekening tujuan" required class="{{ $inputClass }}">
            </div>
            <div>
                <label for="po-holder" class="{{ $labelClass }}">Atas nama</label>
                <input id="po-holder" type="text" name="account_holder" placeholder="Nama pemilik rekening" required class="{{ $inputClass }}">
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            @unless($canWithdraw)
                <p class="text-xs text-[#3b2230]/55">Saldo minimal Rp 50.000 untuk mengajukan penarikan.</p>
            @endunless
            <button type="submit" @disabled(! $canWithdraw)
                class="px-5 py-2.5 text-sm font-semibold rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60
                    {{ $canWithdraw ? 'text-white bg-[#3b2230] hover:bg-[#3b2230]/90' : 'text-[#3b2230]/40 bg-[#3b2230]/[0.08] cursor-not-allowed' }}">
                Ajukan penarikan
            </button>
        </div>
    </form>

    <!-- Riwayat -->
    <h3 class="mb-3 text-lg [font-family:'Fraunces',serif] font-normal">Riwayat penarikan</h3>
    <div class="overflow-x-auto border border-[#3b2230]/10 rounded-md">
        <table class="w-full text-left text-sm">
            <thead class="text-xs text-[#3b2230]/60 bg-[#3b2230]/[0.04] border-b border-[#3b2230]/10">
                <tr>
                    <th scope="col" class="px-4 py-3 font-medium">Tanggal</th>
                    <th scope="col" class="px-4 py-3 font-medium">Nominal</th>
                    <th scope="col" class="px-4 py-3 font-medium">Tujuan transfer</th>
                    <th scope="col" class="px-4 py-3 font-medium">Status</th>
                    <th scope="col" class="px-4 py-3 font-medium">Bukti transfer</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#3b2230]/10">
                @forelse($myPayouts as $py)
                    @php [$statusText, $statusClass] = $statusLabels[$py->status] ?? [$py->status, 'bg-[#3b2230]/[0.07] text-[#3b2230]/70']; @endphp
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-[#3b2230]/60">{{ $py->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">Rp {{ number_format($py->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span class="block">{{ $py->bank_name }} &ndash; {{ $py->account_number }}</span>
                            <span class="block text-xs text-[#3b2230]/55">a/n {{ $py->account_holder }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-sm {{ $statusClass }}">{{ $statusText }}</span>
                            @if($py->status === 'rejected' && $py->admin_notes)
                                <span class="block mt-1 text-xs text-[#3b2230]/60">{{ $py->admin_notes }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($py->proof_image)
                                <a href="{{ Storage::url($py->proof_image) }}" target="_blank" rel="noopener"
                                   class="text-[#3b2230]/70 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/25 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                                    Lihat struk
                                </a>
                            @else
                                <span class="text-[#3b2230]/40">&ndash;</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#3b2230]/60">Belum ada pengajuan penarikan dana.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>