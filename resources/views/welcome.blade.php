<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlowMUA - Platform Direktori & Reservasi Makeup Artist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-800 antialiased min-h-screen flex flex-col font-sans">

    {{-- Header / Navbar --}}
    @include('welcome.navbar')

    {{-- Main Content --}}
    <main class="flex-1">
        {{-- Hero Section & Form Pencarian --}}
        @include('welcome.hero')

        {{-- Section Katalog MUA --}}
        @include('welcome.catalog')
    </main>

    {{-- Footer --}}
    @include('welcome.footer')

</body>
</html>