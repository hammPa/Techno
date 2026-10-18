<section class="p-6 sm:p-7 bg-white border border-[#3b2230]/10 rounded-lg">
    <div class="mb-5">
        <h2 class="text-2xl [font-family:'Fraunces',serif] font-normal">Jadwal &amp; jam operasional</h2>
        <p class="mt-1 text-sm text-[#3b2230]/60">Tentukan hari aktif dan jam kerja agar pesanan klien tidak bertabrakan atau masuk di luar jam buka.</p>
    </div>

    <form action="{{ route('mua.schedules.update') }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="border border-[#3b2230]/10 rounded-md divide-y divide-[#3b2230]/10">
            @foreach($days as $dayIndex => $dayName)
                @php
                    $schedule  = $schedules->get($dayIndex);
                    $isActive  = old("schedules.{$dayIndex}.is_active", $schedule ? $schedule->is_active : ($dayIndex !== 0));
                    $startTime = old("schedules.{$dayIndex}.start_time", $schedule ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '08:00');
                    $endTime   = old("schedules.{$dayIndex}.end_time", $schedule ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '17:00');
                @endphp

                <div class="p-4 sm:px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4" id="row-day-{{ $dayIndex }}">
                    <input type="hidden" name="schedules[{{ $dayIndex }}][day_of_week]" value="{{ $dayIndex }}">

                    <!-- Status hari aktif -->
                    <div class="flex items-center gap-3 sm:w-40">
                        <input type="checkbox"
                               name="schedules[{{ $dayIndex }}][is_active]"
                               value="1"
                               id="active-{{ $dayIndex }}"
                               class="schedule-toggle w-4 h-4 rounded-sm border-[#3b2230]/30 text-[#3b2230] focus:ring-2 focus:ring-[#3b2230]/40 cursor-pointer"
                               data-target="{{ $dayIndex }}"
                               @checked($isActive)>
                        <label for="active-{{ $dayIndex }}" class="text-sm font-semibold cursor-pointer select-none">
                            {{ $dayName }}
                        </label>
                    </div>

                    <!-- Jam operasional -->
                    <div class="flex items-center gap-3 sm:justify-end transition-opacity" id="time-inputs-{{ $dayIndex }}">
                        <label class="flex items-center gap-2">
                            <span class="text-xs text-[#3b2230]/55">Buka</span>
                            <input type="time"
                                   name="schedules[{{ $dayIndex }}][start_time]"
                                   value="{{ $startTime }}"
                                   class="px-2.5 py-1.5 bg-white border border-[#3b2230]/15 rounded-md text-sm focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/40"
                                   required>
                        </label>

                        <span class="text-[#3b2230]/30" aria-hidden="true">&ndash;</span>

                        <label class="flex items-center gap-2">
                            <span class="text-xs text-[#3b2230]/55">Tutup</span>
                            <input type="time"
                                   name="schedules[{{ $dayIndex }}][end_time]"
                                   value="{{ $endTime }}"
                                   class="px-2.5 py-1.5 bg-white border border-[#3b2230]/15 rounded-md text-sm focus:outline-none focus:border-[#3b2230]/50 focus-visible:ring-2 focus-visible:ring-[#3b2230]/40"
                                   required>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-5 py-2.5 text-sm font-semibold text-white bg-[#3b2230] hover:bg-[#3b2230]/90 rounded-md transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#3b2230]/60">
                Simpan jadwal
            </button>
        </div>
    </form>
</section>

<script>
    document.querySelectorAll('.schedule-toggle').forEach(toggle => {
        function updateRowState(el) {
            const container = document.getElementById(`time-inputs-${el.dataset.target}`);
            if (!container) return;
            container.classList.toggle('opacity-40', !el.checked);
            container.classList.toggle('pointer-events-none', !el.checked);
        }

        toggle.addEventListener('change', () => updateRowState(toggle));
        updateRowState(toggle);
    });
</script>