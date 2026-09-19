<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Admin - Verifikasi Pembayaran & Manajemen GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen font-sans">
    <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-xs">
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-sm">🛡️</span>
            <span class="font-bold text-base text-slate-900">GlowMUA <span class="text-rose-600">Admin Control</span></span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-xs text-slate-500">{{ $user->email }} (Administrator)</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-red-600 hover:underline font-semibold transition">Keluar</button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Dashboard Administrator</h1>
            <p class="text-xs text-slate-500">Kelola konfirmasi pembayaran, pantau mitra MUA, dan data pengguna terdaftar</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl flex items-center justify-between shadow-xs">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-xs">
                <span>⚠️ {{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Kartu Statistik Admin -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl text-xl">💳</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Perlu Diverifikasi</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $payments->where('status', 'pending')->count() }} Pembayaran</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                <div class="p-3 bg-pink-50 text-pink-600 rounded-xl text-xl">💄</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Total Mitra MUA</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $muaUsers->count() }} Terdaftar</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl text-xl">👥</div>
                <div>
                    <span class="text-[11px] text-slate-400 font-medium">Total Akun Klien</span>
                    <h3 class="text-lg font-bold text-slate-900">{{ $clientUsers->count() }} Pengguna</h3>
                </div>
            </div>
        </div>

        <!-- Tabel Verifikasi Bukti Transfer Klien -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs mb-8">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-sm sm:text-base text-slate-900">Verifikasi Bukti Transfer Manual</h2>
                    <p class="text-[11px] text-slate-400">Pastikan saldo sudah masuk ke rekening platform sebelum disetujui</p>
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
                            <th class="p-4">Status Pembayaran</th>
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
                                        <form action="{{ route('admin.payments.verify', $pm->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa dana transfer ini sudah valid dan masuk rekening?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs transition">
                                                ✓ Setujui Transfer
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Selesai Diverifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">
                                    Belum ada transaksi pembayaran yang dikirimkan oleh klien.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grid 2 Kolom: Tabel Daftar MUA & Tabel Daftar Klien -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tabel Daftar MUA -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-sm text-slate-900">Daftar Makeup Artist (MUA)</h2>
                        <p class="text-[11px] text-slate-400">Data akun mitra yang terdaftar</p>
                    </div>
                    <span class="px-2.5 py-0.5 bg-pink-50 text-pink-700 text-xs font-bold rounded-full">
                        {{ $muaUsers->count() }} MUA
                    </span>
                </div>

                <div class="overflow-x-auto max-h-96">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold sticky top-0">
                            <tr>
                                <th class="p-3">Artisan / Studio</th>
                                <th class="p-3">Kontak & Domisili</th>
                                <th class="p-3 text-center">Paket</th>
                                <th class="p-3 text-center">Total Pesanan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($muaUsers as $mua)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3">
                                        <div class="font-bold text-slate-900">{{ $mua->muaProfile->studio_name ?? $mua->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $mua->email }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-slate-700 font-medium">{{ $mua->phone ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-400">📍 {{ $mua->muaProfile->city ?? 'Belum atur kota' }}</div>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md font-semibold text-[11px]">
                                            {{ $mua->services->count() }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2.5 py-0.5 bg-rose-50 text-rose-700 rounded-md font-bold text-[11px]">
                                            {{ $mua->mua_bookings_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-400">Belum ada akun MUA terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Daftar Klien -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-sm text-slate-900">Daftar Pengguna (Klien)</h2>
                        <p class="text-[11px] text-slate-400">Data customer yang memesan riasan</p>
                    </div>
                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
                        {{ $clientUsers->count() }} Klien
                    </span>
                </div>

                <div class="overflow-x-auto max-h-96">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold sticky top-0">
                            <tr>
                                <th class="p-3">Nama Klien</th>
                                <th class="p-3">Kontak</th>
                                <th class="p-3 text-center">Verifikasi Email</th>
                                <th class="p-3 text-center">Pesanan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($clientUsers as $cli)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3">
                                        <div class="font-bold text-slate-900">{{ $cli->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $cli->email }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-slate-700 font-medium">{{ $cli->phone ?? '-' }}</div>
                                        <div class="text-[10px] text-slate-400">Bergabung: {{ $cli->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="p-3 text-center">
                                        @if($cli->email_verified_at)
                                            <span class="text-[10px] px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full font-bold">Aktif</span>
                                        @else
                                            <span class="text-[10px] px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full font-bold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 rounded-md font-bold text-[11px]">
                                            {{ $cli->client_bookings_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-400">Belum ada akun klien terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>