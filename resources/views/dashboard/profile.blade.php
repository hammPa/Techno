<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>

    {{-- Gunakan salah satu cara load Tailwind di bawah ini: --}}
    
    {{-- Opsi A: Jika project Laravel menggunakan Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Opsi B: Jika ingin langsung coba tanpa setup build tool (CDN Tailwind) --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>
<body class="bg-gray-50 min-h-screen py-10">

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md border border-gray-100">
        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">Edit Profil</h2>
            <p class="text-sm text-gray-500">Perbarui informasi akun dan kredensial Anda.</p>
        </div>

        {{-- Flash message notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-5 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', auth()->user()->name ?? 'John Doe') }}" 
                    required 
                    class="w-full px-3 py-2 border @error('name') border-rose-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                >
                @error('name')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email & Verification Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', auth()->user()->email ?? 'johndoe@example.com') }}" 
                        required 
                        class="w-full px-3 py-2 border @error('email') border-rose-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi Email</label>
                    <div class="flex items-center h-10 px-3 border border-gray-200 bg-gray-50 rounded-lg text-sm text-gray-600">
                        @if (auth()->user()?->email_verified_at)
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                            Terverifikasi ({{ auth()->user()->email_verified_at->format('Y-m-d') }})
                        @else
                            <span class="inline-block w-2 h-2 rounded-full bg-amber-500 mr-2"></span>
                            Belum Terverifikasi
                        @endif
                    </div>
                </div>
            </div>

            <!-- Phone & Role -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-3 py-2 border @error('phone') border-rose-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                    @error('phone')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role (Read-only) -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded">Hanya Baca</span>
                    </div>
                    <input 
                        type="text" 
                        id="role" 
                        name="role" 
                        value="{{ ucfirst(auth()->user()->role ?? 'User') }}" 
                        readonly 
                        class="w-full px-3 py-2 border border-gray-200 bg-gray-100 text-gray-500 rounded-lg cursor-not-allowed text-sm focus:outline-none select-none"
                    >
                </div>
            </div>

            <!-- Password Section -->
            <div class="pt-4 border-t border-gray-100">
                <h3 class="text-sm font-medium text-gray-800 mb-1">Ubah Password</h3>
                <p class="text-xs text-gray-500 mb-3">Kosongkan jika tidak ingin mengganti password saat ini.</p>
                
                <div class="space-y-3">
                    <div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Password baru (opsional)" 
                            class="w-full px-3 py-2 border @error('password') border-rose-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Konfirmasi password baru" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        >
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a 
                    href="{{ url()->previous() }}" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors inline-block"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>