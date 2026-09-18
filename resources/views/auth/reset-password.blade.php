<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Password - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/40 text-slate-800 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-rose-950/5 border border-rose-100 p-8 sm:p-10">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Atur Ulang Password</h1>
            <p class="text-xs text-slate-500 mt-1">Silakan buat kata sandi baru untuk akun Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-3.5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Email</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" required readonly
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-100 text-slate-500 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Password Baru</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
            </div>

            <button type="submit" 
                class="w-full mt-2 py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-rose-200">
                Simpan Password Baru
            </button>
        </form>
    </div>
</body>
</html>