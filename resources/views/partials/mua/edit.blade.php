<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Rias - GlowMUA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $inputClass = 'w-full px-3.5 py-2.5 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/30 transition-colors';
    $labelClass = 'block mb-1.5 text-sm font-medium text-[#3b2230]/80';
    $categories = [
        'graduation' => 'Wisuda / Graduation',
        'wedding'    => 'Wedding / Bridal',
        'engagement' => 'Lamaran / Engagement',
        'photoshoot' => 'Photoshoot / Studio',
        'other'      => 'Lainnya',
    ];
@endphp
<body class="bg-[#3b2230]/[0.04] text-[#3b2230] min-h-screen antialiased py-8 sm:py-12">
    <div class="max-w-2xl mx-auto px-4">

        <a href="{{ route('dashboard') }}"
           class="inline-block mb-5 text-sm text-[#3b2230]/60 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/25 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
            Kembali ke dashboard
        </a>

        @if($errors->any())
            <div role="alert" class="mb-5 p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-md">
                <p class="font-semibold">Periksa kembali data yang dimasukkan:</p>
                <ul class="mt-1 pl-4 space-y-0.5 list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
            <div class="mb-5">
                <h1 class="text-2xl [font-family:'Fraunces',serif] font-normal">Edit paket rias</h1>
                <p class="mt-1 text-sm text-[#3b2230]/60">Sesuaikan tarif, durasi kerja, atau fasilitas layanan Anda.</p>
            </div>

            <form action="{{ route('services.update', $service->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="title" class="{{ $labelClass }}">Nama paket</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $service->title) }}" required placeholder="Contoh: Makeup wisuda glowing" class="{{ $inputClass }}">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category" class="{{ $labelClass }}">Kategori</label>
                        <select id="category" name="category" required class="{{ $inputClass }}">
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $service->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="duration_minutes" class="{{ $labelClass }}">Durasi (menit)</label>
                        <input id="duration_minutes" type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" min="15" step="15" required class="{{ $inputClass }}">
                    </div>
                </div>

                <div>
                    <label for="price" class="{{ $labelClass }}">Harga (Rp)</label>
                    <input id="price" type="number" name="price" value="{{ old('price', (int) $service->price) }}" min="0" step="5000" required placeholder="350000" class="{{ $inputClass }}">
                </div>

                <div>
                    <label for="description" class="{{ $labelClass }}">Keterangan / fasilitas</label>
                    <textarea id="description" name="description" rows="3" placeholder="Termasuk hairdo/hijab do, bulu mata premium, dll." class="{{ $inputClass }}">{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 border-t border-[#3b2230]/10">
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2.5 text-sm font-semibold text-[#3b2230]/70 hover:text-[#3b2230] hover:bg-[#3b2230]/[0.05] rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>