<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-sm sm:text-base text-slate-900">Daftar Mitra Makeup Artist (MUA)</h2>
            <p class="text-[11px] text-slate-400">Total mitra yang terdaftar dan membuka booking jasa</p>
        </div>
        <span class="px-2.5 py-0.5 bg-pink-50 text-pink-700 text-xs font-bold rounded-full border border-pink-100">
            {{ $muaUsers->count() }} Mitra
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200">
                <tr>
                    <th class="p-4">Artisan / Studio</th>
                    <th class="p-4">Kontak & Domisili</th>
                    <th class="p-4 text-center">Jumlah Paket</th>
                    <th class="p-4 text-center">Total Reservasi</th>
                    <th class="p-4">Media Sosial</th>
                    <th class="p-4">Tanggal Gabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($muaUsers as $mua)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4">
                            <div class="font-bold text-slate-900 text-sm">
                                {{ $mua->muaProfile->studio_name ?? $mua->name }}
                            </div>
                            <div class="text-[11px] text-slate-400">{{ $mua->email }}</div>
                            @if($mua->muaProfile && $mua->muaProfile->bio)
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5 italic max-w-xs">
                                    "{{ $mua->muaProfile->bio }}"
                                </p>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="text-slate-700 font-medium">
                                @if($mua->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mua->phone) }}" target="_blank" class="text-rose-600 hover:underline">
                                        {{ $mua->phone }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                📍 {{ $mua->muaProfile->city ?? 'Belum atur kota' }}
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg font-semibold text-xs inline-block">
                                {{ $mua->services->count() }} Paket
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-lg font-bold text-xs inline-block">
                                {{ $mua->mua_bookings_count }} Order
                            </span>
                        </td>
                        <td class="p-4">
                            @if($mua->muaProfile && $mua->muaProfile->instagram_username)
                                <a href="https://instagram.com/{{ ltrim($mua->muaProfile->instagram_username, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-slate-600 hover:text-pink-600 transition font-medium">
                                    <span>📸</span> @<span>{{ ltrim($mua->muaProfile->instagram_username, '@') }}</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-[11px]">-</span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-500 whitespace-nowrap">
                            {{ $mua->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">
                            Belum ada mitra MUA yang mendaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>