<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - TemuMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,400;9..144,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] [font-family:'DM_Sans',system-ui,sans-serif] antialiased min-h-screen py-10 px-4">

    <div class="max-w-2xl mx-auto">

        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 mb-5 text-sm text-[#3b2230]/65 hover:text-[#3b2230] transition-colors">
            <span aria-hidden="true">←</span> Kembali ke dashboard
        </a>

        <div class="bg-white p-6 sm:p-8 rounded-lg border border-[#3b2230]/10">
            <div class="mb-6 border-b border-[#3b2230]/10 pb-5">
                <h1 class="text-3xl [font-family:'Fraunces',serif] font-normal leading-tight">Edit profil</h1>
                <p class="mt-1.5 text-sm text-[#3b2230]/60">Perbarui informasi akun dan kredensial Anda.</p>
            </div>

            {{-- Flash message notifikasi sukses --}}
            @if (session('success'))
                <div role="status" class="mb-5 px-4 py-3 border-l-2 border-[#4d7a5a] bg-[#e5eee6] text-[#2f5a3c] text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-[#3b2230]/80 mb-1.5">Nama lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name"
                        class="w-full px-3 py-2.5 border @error('name') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-md bg-white focus:outline-none focus:ring-0 focus:border-[#3b2230] text-sm">
                    @error('name')
                        <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email & status verifikasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-[#3b2230]/80 mb-1.5">Alamat email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email"
                            class="w-full px-3 py-2.5 border @error('email') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-md bg-white focus:outline-none focus:ring-0 focus:border-[#3b2230] text-sm">
                        @error('email')
                            <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-[#3b2230]/50">Mengganti email akan mengatur ulang status verifikasi.</p>
                        @enderror
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-[#3b2230]/80 mb-1.5">Status verifikasi email</span>
                        <div class="flex items-center px-3 py-2.5 border border-[#3b2230]/10 bg-[#f3ece4] rounded-md text-sm text-[#3b2230]/70">
                            @if (auth()->user()->email_verified_at)
                                <span class="inline-block w-2 h-2 rounded-full bg-[#4d7a5a] mr-2" aria-hidden="true"></span>
                                Terverifikasi ({{ auth()->user()->email_verified_at->format('d-m-Y') }})
                            @else
                                <span class="inline-block w-2 h-2 rounded-full bg-[#b8863b] mr-2" aria-hidden="true"></span>
                                Belum terverifikasi
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Telepon & role -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#3b2230]/80 mb-1.5">Nomor telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx" autocomplete="tel"
                            class="w-full px-3 py-2.5 border @error('phone') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-md bg-white placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-0 focus:border-[#3b2230] text-sm">
                        @error('phone')
                            <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role (hanya tampilan, tidak dikirim ke server) -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="role" class="block text-sm font-medium text-[#3b2230]/80">Role</label>
                            <span class="text-xs text-[#3b2230]/70 bg-[#3b2230]/[0.06] px-2 py-0.5 rounded">Hanya baca</span>
                        </div>
                        <input type="text" id="role" value="{{ ucfirst(auth()->user()->role) }}" readonly tabindex="-1"
                            class="w-full px-3 py-2.5 border border-[#3b2230]/10 bg-[#f3ece4] text-[#3b2230]/55 rounded-md cursor-not-allowed text-sm focus:outline-none select-none">
                    </div>
                </div>

                <!-- Ubah password -->
                <div class="pt-5 border-t border-[#3b2230]/10">
                    <h2 class="text-sm font-semibold mb-1">Ubah password</h2>
                    <p class="text-xs text-[#3b2230]/60 mb-4">Kosongkan jika tidak ingin mengganti password saat ini.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-[#3b2230]/80 mb-1.5">Password baru</label>
                            <input type="password" id="password" name="password" placeholder="Opsional" autocomplete="new-password"
                                class="w-full px-3 py-2.5 border @error('password') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-md bg-white placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-0 focus:border-[#3b2230] text-sm">
                            @error('password')
                                <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-[#3b2230]/80 mb-1.5">Konfirmasi password baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" autocomplete="new-password"
                                class="w-full px-3 py-2.5 border border-[#3b2230]/20 rounded-md bg-white placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-0 focus:border-[#3b2230] text-sm">
                        </div>
                    </div>
                </div>

                <!-- Tombol aksi -->
                <div class="flex justify-end gap-3 pt-5 border-t border-[#3b2230]/10">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2.5 border border-[#3b2230]/20 hover:border-[#3b2230] rounded-md text-sm font-medium text-[#3b2230]/80 transition-colors inline-block focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#3b2230] text-[#faf6f1] rounded-md text-sm font-medium hover:bg-[#2a1620] transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>