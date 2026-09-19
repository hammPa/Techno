<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-sm sm:text-base text-slate-900">Daftar Akun Klien</h2>
            <p class="text-[11px] text-slate-400">Daftar pengguna yang memesan layanan MUA</p>
        </div>
        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
            {{ $clientUsers->count() }} Klien
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold">
                <tr>
                    <th class="p-4">Nama Lengkap</th>
                    <th class="p-4">Kontak (WhatsApp)</th>
                    <th class="p-4 text-center">Verifikasi Email</th>
                    <th class="p-4 text-center">Total Reservasi</th>
                    <th class="p-4">Bergabung Sejak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($clientUsers as $cli)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $cli->name }}</div>
                            <div class="text-[11px] text-slate-400">{{ $cli->email }}</div>
                        </td>
                        <td class="p-4">
                            <div class="text-slate-700 font-medium">{{ $cli->phone ?? '-' }}</div>
                        </td>
                        <td class="p-4 text-center">
                            @if($cli->email_verified_at)
                                <span class="text-[10px] px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-bold">Aktif</span>
                            @else
                                <span class="text-[10px] px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full font-bold">Belum Verif</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg font-bold text-xs">
                                {{ $cli->client_bookings_count }} Order
                            </span>
                        </td>
                        <td class="p-4 text-slate-500">
                            {{ $cli->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Belum ada akun klien yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>