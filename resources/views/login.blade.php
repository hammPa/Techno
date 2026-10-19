<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - TemuMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#3b2230]/[0.04] text-[#3b2230] min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 antialiased">
    <div class="w-full max-w-md md:max-w-[56rem] lg:max-w-[72rem] mx-auto bg-white rounded-lg border border-[#3b2230]/10 overflow-hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[1.1fr_1fr] md:min-h-[600px] lg:min-h-[680px]">

        <!-- Sisi kiri (desktop) -->
        <div class="hidden md:flex flex-col justify-between gap-10 bg-[#3b2230] text-white p-10 lg:px-16 lg:py-14">
            <a href="{{ route('home') }}" class="self-start text-2xl [font-family:'Fraunces',serif] focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded-sm">TemuMUA</a>

            <div class="max-w-md space-y-4">
                <h2 class="text-3xl lg:text-[2.5rem] [font-family:'Fraunces',serif] font-normal leading-tight">
                    Temukan MUA terbaik untuk momen berhargamu.
                </h2>
                <p class="text-sm lg:text-base leading-relaxed text-white/70">
                    Akses jadwal booking, portofolio, dan layanan makeup profesional dalam satu platform.
                </p>
            </div>

            <p class="text-xs lg:text-sm text-white/50">&copy; 2026 TemuMUA</p>
        </div>

        <!-- Sisi kanan (form) -->
        <div class="p-6 sm:p-10 lg:px-20 lg:py-14 flex flex-col justify-center">
            <div class="w-full max-w-[26rem] mx-auto">

                <!-- Wordmark (mobile) -->
                <a href="{{ route('home') }}" class="block mb-8 text-center text-2xl [font-family:'Fraunces',serif] md:hidden">TemuMUA</a>

                <div class="mb-7 text-center md:text-left">
                    <h1 class="text-3xl [font-family:'Fraunces',serif] font-normal">Selamat datang</h1>
                    <p class="mt-2 text-sm text-[#3b2230]/60">Masuk untuk melihat agenda reservasi MUA.</p>
                </div>

                @if ($errors->any())
                    <div role="alert" class="mb-5 p-3 text-sm text-red-800 bg-red-50 border border-red-200 rounded-md">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div role="status" class="mb-5 p-3 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-1.5 text-sm font-medium text-[#3b2230]/80">Email</label>
                        <div class="flex items-center gap-3 px-3.5 bg-white rounded-md border border-[#3b2230]/15 focus-within:border-[#3b2230]/50 focus-within:ring-2 focus-within:ring-[#3b2230]/30 transition-colors">
                            <svg class="w-5 h-5 shrink-0 text-[#3b2230]/40" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com"
                                class="flex-1 min-w-0 py-2.5 bg-transparent border-0 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:ring-0">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-1.5 text-sm font-medium text-[#3b2230]/80">Password</label>
                        <div class="flex items-center gap-3 px-3.5 bg-white rounded-md border border-[#3b2230]/15 focus-within:border-[#3b2230]/50 focus-within:ring-2 focus-within:ring-[#3b2230]/30 transition-colors">
                            <svg class="w-5 h-5 shrink-0 text-[#3b2230]/40" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password Anda"
                                class="flex-1 min-w-0 py-2.5 bg-transparent border-0 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:ring-0">
                            <button type="button" id="togglePassword" aria-label="Tampilkan password"
                                class="shrink-0 p-1 text-[#3b2230]/40 hover:text-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-2">
                        <label for="remember" class="flex items-center gap-2 cursor-pointer">
                            <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded-sm border-[#3b2230]/30 text-[#3b2230] focus:ring-2 focus:ring-[#3b2230]/40">
                            <span class="text-sm text-[#3b2230]/70">Ingat perangkat ini</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-[#3b2230]/60 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/25 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">Lupa password?</a>
                    </div>

                    <button type="submit"
                        class="w-full px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                        Masuk
                    </button>
                </form>

                <p class="mt-7 pt-6 text-center text-sm text-[#3b2230]/60 border-t border-[#3b2230]/10">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('togglePassword');
            var input = document.getElementById('password');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
            });
        })();
    </script>
</body>
</html>