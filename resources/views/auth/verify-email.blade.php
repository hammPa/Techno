<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/40 text-slate-800 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-rose-950/5 border border-rose-100 p-8 text-center">
        <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl mx-auto flex items-center justify-center text-3xl mb-4">
            📩
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Verifikasi Email Anda</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
            Link verifikasi telah dikirim untuk akun <span class="font-semibold text-slate-800">{{ auth()->user()->email }}</span>.<br>
            <span class="text-rose-600 font-medium">(Mode Dev: Link ada di file storage/logs/laravel.log)</span>
        </p>

        @if (session('message'))
            <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                {{ session('message') }}
            </div>
        @endif

        <div class="mt-6 space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-xs sm:text-sm transition shadow-sm shadow-rose-200">
                    Kirim Ulang Link Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2 text-xs font-semibold text-slate-500 hover:text-rose-600 transition">
                    Keluar / Ganti Akun
                </button>
            </form>
        </div>
    </div>
</body>
</html>