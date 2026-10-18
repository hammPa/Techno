<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlowMUA - Direktori &amp; Reservasi Makeup Artist</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#3b2230]/[0.04] text-[#3b2230] antialiased min-h-screen flex flex-col">

    {{-- Header / Navbar --}}
    @include('welcome.navbar')

    {{-- Main Content --}}
    <main class="flex-1">
        {{-- Hero & form pencarian --}}
        @include('welcome.hero')

        {{-- Katalog MUA --}}
        @include('welcome.catalog')
    </main>

    {{-- Footer --}}
    @include('welcome.footer')

</body>
</html>