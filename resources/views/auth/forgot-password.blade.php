<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - GlowMUA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/40 text-slate-800 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-rose-950/5 border border-rose-100 p-8 sm:p-10">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3">
                🔐
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Lupa Password?</h1>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk membuat kata sandi baru.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
            </div>

            <button type="submit" 
                class="w-full py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-rose-200">
                Kirim Tautan Reset Password
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-500">
            Ingat kata sandi Anda? 
            <a href="{{ route('login') }}" class="font-bold text-rose-600 hover:underline">Kembali Masuk</a>
        </p>
    </div>
</body>
</html>