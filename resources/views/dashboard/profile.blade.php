<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f1] text-[#3b2230] antialiased min-h-screen py-10 px-4">

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-[#3b2230]/10">
        <div class="mb-6 border-b border-[#3b2230]/10 pb-4">
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Edit Profil</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Perbarui informasi akun dan kredensial Anda.</p>
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

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-[#3b2230]/80 mb-1">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', auth()->user()->name ?? 'John Doe') }}"
                    required
                    class="w-full px-3 py-2 border @error('name') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#3b2230]/40 focus:border-[#3b2230] text-sm"
                >
                @error('name')
                    <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email & Verification Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-[#3b2230]/80 mb-1">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email ?? 'johndoe@example.com') }}"
                        required
                        class="w-full px-3 py-2 border @error('email') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#3b2230]/40 focus:border-[#3b2230] text-sm"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#3b2230]/80 mb-1">Status Verifikasi Email</label>
                    <div class="flex items-center h-10 px-3 border border-[#3b2230]/10 bg-[#f3ece4] rounded-lg text-sm text-[#3b2230]/70">
                        @if (auth()->user()?->email_verified_at)
                            <span class="inline-block w-2 h-2 rounded-full bg-[#4d7a5a] mr-2"></span>
                            Terverifikasi ({{ auth()->user()->email_verified_at->format('Y-m-d') }})
                        @else
                            <span class="inline-block w-2 h-2 rounded-full bg-[#b8863b] mr-2"></span>
                            Belum Terverifikasi
                        @endif
                    </div>
                </div>
            </div>

            <!-- Phone & Role -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-sm font-medium text-[#3b2230]/80 mb-1">Nomor Telepon</label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-3 py-2 border @error('phone') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-lg bg-white placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-2 focus:ring-[#3b2230]/40 focus:border-[#3b2230] text-sm"
                    >
                    @error('phone')
                        <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role (Read-only) -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="role" class="block text-sm font-medium text-[#3b2230]/80">Role</label>
                        <span class="text-xs text-[#3b2230]/70 bg-[#3b2230]/[0.06] px-2 py-0.5 rounded">Hanya Baca</span>
                    </div>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        value="{{ ucfirst(auth()->user()->role ?? 'User') }}"
                        readonly
                        class="w-full px-3 py-2 border border-[#3b2230]/10 bg-[#f3ece4] text-[#3b2230]/55 rounded-lg cursor-not-allowed text-sm focus:outline-none select-none"
                    >
                </div>
            </div>

            <!-- Password Section -->
            <div class="pt-4 border-t border-[#3b2230]/10">
                <h3 class="text-sm font-medium mb-1">Ubah Password</h3>
                <p class="text-xs text-[#3b2230]/60 mb-3">Kosongkan jika tidak ingin mengganti password saat ini.</p>

                <div class="space-y-3">
                    <div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Password baru (opsional)"
                            class="w-full px-3 py-2 border @error('password') border-[#a23b3b] @else border-[#3b2230]/20 @enderror rounded-lg bg-white placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-2 focus:ring-[#3b2230]/40 focus:border-[#3b2230] text-sm"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-[#a23b3b]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Konfirmasi password baru"
                            class="w-full px-3 py-2 border border-[#3b2230]/20 rounded-lg bg-white placeholder:text-[#3b2230]/40 focus:outline-none focus:ring-2 focus:ring-[#3b2230]/40 focus:border-[#3b2230] text-sm"
                        >
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-[#3b2230]/10">
                <a
                    href="{{ url()->previous() }}"
                    class="px-4 py-2 border border-[#3b2230]/20 rounded-lg text-sm font-medium text-[#3b2230]/80 hover:bg-[#3b2230]/[0.06] transition-colors inline-block focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-4 py-2 bg-[#3b2230] text-[#faf6f1] rounded-lg text-sm font-medium hover:bg-[#2a1620] transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-[#3b2230]"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>