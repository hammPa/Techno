<div class="bg-white rounded-3xl border border-rose-100 p-6 sm:p-8 shadow-xs">
    <div class="mb-6">
        <h2 class="font-bold text-lg text-slate-900">Jadwal & Jam Operasional</h2>
        <p class="text-xs text-slate-500 mt-1">Tentukan hari aktif dan rentang jam kerja Anda agar pesanan klien tidak bertabrakan atau masuk di luar jam buka.</p>
    </div>

    <form action="{{ route('mua.schedules.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="divide-y divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden">
            @foreach($days as $dayIndex =>$dayName)
                @php
                    $schedule =$schedules->get($dayIndex);$isActive = old("schedules.{$dayIndex}.is_active", $schedule ? $schedule->is_active : ($dayIndex !== 0));
                    $startTime = old("schedules.{$dayIndex}.start_time", $schedule ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '08:00');
                    $endTime = old("schedules.{$dayIndex}.end_time", $schedule ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '17:00');
                @endphp

                <div class="p-4 sm:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:bg-rose-50/20" id="row-day-{{ $dayIndex }}">
                    <input type="hidden" name="schedules[{{ $dayIndex }}][day_of_week]" value="{{ $dayIndex }}">

                    <!-- Checkbox Status Hari Aktif -->
                    <div class="flex items-center gap-3 w-40">
                        <input type="checkbox" 
                               name="schedules[{{ $dayIndex }}][is_active]" 
                               value="1" 
                               id="active-{{ $dayIndex }}"
                               class="schedule-toggle w-4 h-4 text-rose-600 rounded border-slate-300 focus:ring-rose-500 cursor-pointer"
                               data-target="{{ $dayIndex }}"
                               @checked($isActive)>
                        <label for="active-{{ $dayIndex }}" class="text-xs sm:text-sm font-bold text-slate-800 cursor-pointer select-none">
                            {{ $dayName }}
                        </label>
                    </div>

                    <!-- Input Jam Operasional -->
                    <div class="flex items-center gap-2 sm:gap-3 flex-1 justify-start sm:justify-end" id="time-inputs-{{ $dayIndex }}">
                        <div class="flex items-center gap-1.5">
                            <span class="text-[11px] text-slate-400 font-medium">Buka</span>
                            <input type="time" 
                                   name="schedules[{{ $dayIndex }}][start_time]" 
                                   value="{{ $startTime }}"
                                   class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:bg-white focus:border-rose-500 focus:outline-hidden transition"
                                   required>
                        </div>

                        <span class="text-slate-300 text-xs">—</span>

                        <div class="flex items-center gap-1.5">
                            <span class="text-[11px] text-slate-400 font-medium">Tutup</span>
                            <input type="time" 
                                   name="schedules[{{ $dayIndex }}][end_time]" 
                                   value="{{ $endTime }}"
                                   class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:bg-white focus:border-rose-500 focus:outline-hidden transition"
                                   required>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end pt-3">
            <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition shadow-xs">
                Simpan Jadwal Operasional
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.schedule-toggle').forEach(toggle => {
        function updateRowState(el) {
            const targetId = el.dataset.target;
            const container = document.getElementById(`time-inputs-${targetId}`);
            if (container) {
                if (el.checked) {
                    container.classList.remove('opacity-40', 'pointer-events-none');
                } else {
                    container.classList.add('opacity-40', 'pointer-events-none');
                }
            }
        }

        toggle.addEventListener('change', function () {
            updateRowState(this);
        });

        // Inisialisasi tampilan baris saat halaman dimuat
        updateRowState(toggle);
    });
</script>