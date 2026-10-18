<section class="bg-white border border-[#3b2230]/10 rounded-lg overflow-hidden">
    <div class="p-6 flex items-baseline justify-between gap-4 border-b border-[#3b2230]/10">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Mitra makeup artist</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Total mitra yang terdaftar dan membuka booking jasa.</p>
        </div>
        <span class="shrink-0 text-sm text-[#3b2230]/60">{{ $muaUsers->count() }} mitra</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs text-[#3b2230]/60 bg-[#3b2230]/[0.04] border-b border-[#3b2230]/10">
                <tr>
                    <th scope="col" class="px-4 py-3 font-medium">Artisan / studio</th>
                    <th scope="col" class="px-4 py-3 font-medium">Kontak &amp; domisili</th>
                    <th scope="col" class="px-4 py-3 font-medium">Jumlah paket</th>
                    <th scope="col" class="px-4 py-3 font-medium">Total reservasi</th>
                    <th scope="col" class="px-4 py-3 font-medium">Instagram</th>
                    <th scope="col" class="px-4 py-3 font-medium">Tanggal gabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#3b2230]/10">
                @forelse($muaUsers as $mua)
                    <tr>
                        <td class="px-4 py-3">
                            <span class="block font-semibold">{{ $mua->muaProfile->studio_name ?? $mua->name }}</span>
                            <span class="block text-xs text-[#3b2230]/55">{{ $mua->email }}</span>
                            @if($mua->muaProfile && $mua->muaProfile->bio)
                                <span class="block mt-0.5 max-w-xs text-xs text-[#3b2230]/60 line-clamp-1">{{ $mua->muaProfile->bio }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($mua->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mua->phone) }}" target="_blank" rel="noopener"
                                   class="underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">{{ $mua->phone }}</a>
                            @else
                                <span class="text-[#3b2230]/40">&ndash;</span>
                            @endif
                            <span class="block mt-0.5 text-xs text-[#3b2230]/55">{{ $mua->muaProfile->city ?? 'Belum atur kota' }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $mua->services->count() }} paket</td>
                        <td class="px-4 py-3 font-semibold">{{ $mua->mua_bookings_count }} order</td>
                        <td class="px-4 py-3">
                            @if($mua->muaProfile && $mua->muaProfile->instagram_username)
                                @php $ig = ltrim($mua->muaProfile->instagram_username, '@'); @endphp
                                <a href="https://instagram.com/{{ $ig }}" target="_blank" rel="noopener"
                                   class="underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">&#64;{{ $ig }}</a>
                            @else
                                <span class="text-[#3b2230]/40">&ndash;</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-[#3b2230]/60">{{ $mua->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-[#3b2230]/60">Belum ada mitra MUA yang mendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>