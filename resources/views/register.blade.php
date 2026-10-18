<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - GlowMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $inputClass = 'w-full min-w-0 px-3.5 py-2.5 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/30 transition-colors';
    $labelClass = 'block mb-1.5 text-sm font-medium text-[#3b2230]/80';
    $roleClass  = 'flex items-center justify-center px-3 py-2.5 text-sm font-semibold rounded-md border border-[#3b2230]/15 text-[#3b2230]/70 cursor-pointer transition-colors hover:border-[#3b2230]/40 has-[:checked]:border-[#3b2230] has-[:checked]:bg-[#3b2230]/[0.07] has-[:checked]:text-[#3b2230] has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-[#3b2230]/40';
@endphp
<body class="bg-[#3b2230]/[0.04] text-[#3b2230] min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 antialiased">
    <div class="w-full max-w-md md:max-w-[56rem] lg:max-w-[72rem] mx-auto bg-white rounded-lg border border-[#3b2230]/10 overflow-hidden grid grid-cols-1 md:grid-cols-[1fr_1.2fr] lg:grid-cols-[1fr_1.35fr] md:min-h-[600px] lg:min-h-[700px]">

        <!-- Sisi kiri (desktop) -->
        <div class="hidden md:flex flex-col justify-between gap-10 bg-[#3b2230] text-white p-10 lg:px-14 lg:py-14">
            <a href="{{ route('home') }}" class="self-start text-2xl [font-family:'Fraunces',serif] focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded-sm">GlowMUA</a>

            <div class="space-y-5">
                <h2 class="text-3xl lg:text-[2.5rem] [font-family:'Fraunces',serif] font-normal leading-tight">
                    Kelola booking riasanmu dengan mudah.
                </h2>
                <ul class="space-y-3 text-sm lg:text-base text-white/75">
                    @foreach(['Jadwal teratur tanpa double-booking', 'Transparansi harga paket rias', 'Notifikasi langsung ke calon klien'] as $point)
                        <li class="flex items-start gap-3">
                            <svg class="shrink-0 mt-0.5 w-5 h-5 text-white/60" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <p class="text-xs lg:text-sm text-white/50">&copy; 2026 GlowMUA</p>
        </div>

        <!-- Sisi kanan (form) -->
        <div class="p-6 sm:p-10 lg:px-20 lg:py-14 flex flex-col justify-center">
            <div class="w-full max-w-md lg:max-w-xl mx-auto">

                <a href="{{ route('home') }}" class="block mb-8 text-center text-2xl [font-family:'Fraunces',serif] md:hidden">GlowMUA</a>

                <div class="mb-6 text-center md:text-left">
                    <h1 class="text-3xl [font-family:'Fraunces',serif] font-normal">Buat akun</h1>
                    <p class="mt-2 text-sm text-[#3b2230]/60">Daftar gratis sebagai klien atau makeup artist.</p>
                </div>

                @if ($errors->any())
                    <div role="alert" class="mb-5 p-3 text-sm text-red-800 bg-red-50 border border-red-200 rounded-md">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Peran -->
                    <fieldset>
                        <legend class="{{ $labelClass }}">Daftar sebagai</legend>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="{{ $roleClass }}">
                                <input type="radio" name="role" value="client" {{ old('role', 'client') === 'client' ? 'checked' : '' }} class="sr-only">
                                <span>Klien</span>
                            </label>
                            <label class="{{ $roleClass }}">
                                <input type="radio" name="role" value="mua" {{ old('role') === 'mua' ? 'checked' : '' }} class="sr-only">
                                <span>MUA</span>
                            </label>
                        </div>
                    </fieldset>

                    <!-- Nama & email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="{{ $labelClass }}">Nama lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama Anda" class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label for="email" class="{{ $labelClass }}">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="{{ $inputClass }}">
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="phone" class="{{ $labelClass }}">WhatsApp</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="08xxxxxxxxxx" class="{{ $inputClass }}">
                    </div>

                    <!-- Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="{{ $labelClass }}">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label for="password_confirmation" class="{{ $labelClass }}">Konfirmasi password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" class="{{ $inputClass }}">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                        Daftar akun
                    </button>
                </form>

                <p class="mt-6 pt-6 text-center text-sm text-[#3b2230]/60 border-t border-[#3b2230]/10">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/30 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>