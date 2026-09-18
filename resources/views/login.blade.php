<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/40 text-slate-800 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl shadow-rose-950/5 border border-rose-100 overflow-hidden grid grid-cols-1 md:grid-cols-2">
        <!-- Sisi Kiri (Desktop Only) -->
        <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-rose-500 to-pink-600 p-10 text-white">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-bold text-xl">
                <span class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">✨</span>
                <span>GlowMUA</span>
            </a>
            <div class="space-y-3">
                <span class="text-xs uppercase tracking-wider font-semibold px-3 py-1 bg-white/20 rounded-full inline-block">
                    Makeup Artist Directory
                </span>
                <h2 class="text-2xl font-bold leading-snug">
                    Temukan MUA terbaik untuk momen berhargamu.
                </h2>
                <p class="text-rose-100 text-xs leading-relaxed">
                    Akses jadwal booking, portofolio, dan layanan makeup profesional dalam satu platform.
                </p>
            </div>
            <div class="text-xs text-rose-200">
                © 2026 GlowMUA Platform
            </div>
        </div>

        <!-- Sisi Kanan (Form) -->
        <div class="p-8 sm:p-10 flex flex-col justify-center">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Selamat Datang</h1>
                <p class="text-xs text-slate-500 mt-1">Masuk untuk melihat agenda reservasi MUA</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Password</label>
                        <a href="#" class="text-xs text-rose-600 font-medium hover:underline">Lupa?</a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                    <label for="remember" class="ml-2 text-xs text-slate-600">Ingat perangkat ini</label>
                </div>

                <button type="submit" 
                    class="w-full py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-rose-200">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-xs text-slate-500">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-bold text-rose-600 hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</body>
</html>