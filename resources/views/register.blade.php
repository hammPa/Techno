<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/40 text-slate-800 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl shadow-rose-950/5 border border-rose-100 overflow-hidden grid grid-cols-1 md:grid-cols-2">
        <!-- Sisi Kiri (Desktop Only) -->
        <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-purple-600 to-rose-600 p-10 text-white">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-bold text-xl">
                <span class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">✨</span>
                <span>GlowMUA</span>
            </a>
            <div class="space-y-4">
                <span class="text-xs uppercase tracking-wider font-semibold px-3 py-1 bg-white/20 rounded-full inline-block">
                    Gabung Komunitas MUA
                </span>
                <h2 class="text-2xl font-bold leading-snug">
                    Kelola booking riasanmu dengan mudah.
                </h2>
                <ul class="text-xs space-y-2 text-rose-100">
                    <li>✓ Jadwal teratur tanpa double-booking</li>
                    <li>✓ Transparansi harga paket rias</li>
                    <li>✓ Notifikasi langsung ke calon klien</li>
                </ul>
            </div>
            <div class="text-xs text-rose-200">
                © 2026 GlowMUA Platform
            </div>
        </div>

        <!-- Sisi Kanan (Form) -->
        <div class="p-8 sm:p-10 flex flex-col justify-center">
            <div class="mb-5">
                <h1 class="text-2xl font-bold text-slate-900">Buat Akun</h1>
                <p class="text-xs text-slate-500 mt-1">Daftar gratis sebagai Klien atau Makeup Artist</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Daftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center justify-center p-2 rounded-xl border border-slate-200 text-xs font-semibold cursor-pointer has-[:checked]:border-rose-600 has-[:checked]:bg-rose-50 has-[:checked]:text-rose-700">
                            <input type="radio" name="role" value="client" {{ old('role', 'client') === 'client' ? 'checked' : '' }} class="hidden">
                            <span>👤 Klien</span>
                        </label>
                        <label class="flex items-center justify-center p-2 rounded-xl border border-slate-200 text-xs font-semibold cursor-pointer has-[:checked]:border-rose-600 has-[:checked]:bg-rose-50 has-[:checked]:text-rose-700">
                            <input type="radio" name="role" value="mua" {{ old('role') === 'mua' ? 'checked' : '' }} class="hidden">
                            <span>💄 MUA</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Anda" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <button type="submit" 
                    class="w-full mt-2 py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-rose-200">
                    Daftar Akun
                </button>
            </form>

            <p class="mt-5 text-center text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-rose-600 hover:underline">Masuk</a>
            </p>
        </div>
    </div>
</body>
</html>