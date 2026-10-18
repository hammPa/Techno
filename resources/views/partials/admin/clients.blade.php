<section class="bg-white border border-[#3b2230]/10 rounded-lg overflow-hidden">
    <div class="p-6 flex items-baseline justify-between gap-4 border-b border-[#3b2230]/10">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Akun klien</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Pengguna yang memesan layanan MUA.</p>
        </div>
        <span class="shrink-0 text-sm text-[#3b2230]/60">{{ $clientUsers->count() }} klien</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs text-[#3b2230]/60 bg-[#3b2230]/[0.04] border-b border-[#3b2230]/10">
                <tr>
                    <th scope="col" class="px-4 py-3 font-medium">Nama lengkap</th>
                    <th scope="col" class="px-4 py-3 font-medium">Kontak (WhatsApp)</th>
                    <th scope="col" class="px-4 py-3 font-medium">Verifikasi email</th>
                    <th scope="col" class="px-4 py-3 font-medium">Total reservasi</th>
                    <th scope="col" class="px-4 py-3 font-medium">Bergabung sejak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#3b2230]/10">
                @forelse($clientUsers as $cli)
                    <tr>
                        <td class="px-4 py-3">
                            <span class="block font-semibold">{{ $cli->name }}</span>
                            <span class="block text-xs text-[#3b2230]/55">{{ $cli->email }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $cli->phone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($cli->email_verified_at)
                                <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-sm bg-emerald-50 text-emerald-800">Aktif</span>
                            @else
                                <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-sm bg-amber-50 text-amber-800">Belum verifikasi</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $cli->client_bookings_count }} order</td>
                        <td class="px-4 py-3 whitespace-nowrap text-[#3b2230]/60">{{ $cli->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#3b2230]/60">Belum ada akun klien yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>