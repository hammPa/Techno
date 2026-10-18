@php
    $categoryLabels = [
        'graduation' => 'Wisuda',
        'wedding'    => 'Wedding',
        'engagement' => 'Lamaran',
        'photoshoot' => 'Photoshoot',
        'other'      => 'Lainnya',
    ];
    $inputClass = 'w-full px-3 py-2 bg-white rounded-md border border-[#3b2230]/15 text-sm placeholder:text-[#3b2230]/35 focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/40';
    $labelClass = 'block mb-1 text-xs font-medium text-[#3b2230]/70';
@endphp

<section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg mb-6">
    <div class="flex items-baseline justify-between gap-4 mb-5">
        <div>
            <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Paket rias</h2>
            <p class="mt-1 text-sm text-[#3b2230]/60">Paket yang tampil dan bisa dipesan oleh calon klien.</p>
        </div>
        <span class="shrink-0 text-sm text-[#3b2230]/60">{{ $services->count() }} paket</span>
    </div>

    <!-- Form tambah paket -->
    <form action="{{ route('services.store') }}" method="POST" class="p-4 mb-6 space-y-3 border border-[#3b2230]/10 rounded-md bg-[#3b2230]/[0.03]">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <label for="svc-title" class="{{ $labelClass }}">Nama paket</label>
                <input id="svc-title" type="text" name="title" required placeholder="Contoh: Makeup wisuda glowing" class="{{ $inputClass }}">
            </div>

            <div>
                <label for="svc-category" class="{{ $labelClass }}">Kategori</label>
                <select id="svc-category" name="category" required class="{{ $inputClass }}">
                    <option value="graduation">Wisuda / Graduation</option>
                    <option value="wedding">Wedding / Bridal</option>
                    <option value="engagement">Lamaran / Engagement</option>
                    <option value="photoshoot">Photoshoot / Studio</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>

            <div>
                <label for="svc-price" class="{{ $labelClass }}">Harga (Rp)</label>
                <input id="svc-price" type="number" name="price" required placeholder="350000" min="0" step="5000" class="{{ $inputClass }}">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <label for="svc-duration" class="{{ $labelClass }}">Durasi (menit)</label>
                <input id="svc-duration" type="number" name="duration_minutes" value="120" required min="15" step="15" class="{{ $inputClass }}">
            </div>

            <div class="sm:col-span-3">
                <label for="svc-desc" class="{{ $labelClass }}">Keterangan / fasilitas</label>
                <input id="svc-desc" type="text" name="description" placeholder="Termasuk hairdo/hijab do, bulu mata premium, dll." class="{{ $inputClass }}">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                Tambah paket
            </button>
        </div>
    </form>

    <!-- Daftar paket -->
    <div class="border border-[#3b2230]/10 rounded-md divide-y divide-[#3b2230]/10">
        @forelse($services as $item)
            <article class="p-4 sm:px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-sm font-semibold">{{ $item->title }}</h3>
                        <span class="px-2 py-0.5 text-xs rounded-sm bg-[#3b2230]/[0.07] text-[#3b2230]/70">
                            {{ $categoryLabels[$item->category] ?? $item->category }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm leading-relaxed text-[#3b2230]/70">{{ $item->description ?? 'Tidak ada keterangan tambahan.' }}</p>
                    <p class="mt-1 text-xs text-[#3b2230]/50">Durasi {{ $item->duration_minutes }} menit</p>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-4 shrink-0">
                    <span class="text-sm font-semibold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>

                    <div class="flex items-center gap-3 text-sm">
                        <a href="{{ route('services.edit', $item->id) }}"
                           class="text-[#3b2230]/60 hover:text-[#3b2230] underline underline-offset-4 decoration-[#3b2230]/25 hover:decoration-[#3b2230] rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3b2230]/40">
                            Edit
                        </a>

                        <form action="{{ route('services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus paket rias ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-700/80 hover:text-red-700 underline underline-offset-4 decoration-red-700/25 hover:decoration-red-700 rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-red-700/40">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="py-12 text-center">
                <p class="text-sm text-[#3b2230]/60">Belum ada paket rias. Buat paket pertama lewat form di atas.</p>
            </div>
        @endforelse
    </div>
</section>