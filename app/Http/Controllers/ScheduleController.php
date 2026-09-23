<?php

namespace App\Http\Controllers;

use App\Models\MuaSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Memperbarui jadwal kerja operasional MUA.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schedules' => ['required', 'array'],
            'schedules.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'schedules.*.is_active' => ['nullable', 'boolean'],
            'schedules.*.start_time' => ['required', 'date_format:H:i'],
            'schedules.*.end_time' => ['required', 'date_format:H:i', 'after:schedules.*.start_time'],
        ]);

        $userId = auth()->id();

        foreach ($validated['schedules'] as $dayData) {
            MuaSchedule::updateOrCreate(
                [
                    'user_id' => $userId,
                    'day_of_week' => $dayData['day_of_week'],
                ],
                [
                    'start_time' => $dayData['start_time'],
                    'end_time' => $dayData['end_time'],
                    'is_active' => !empty($dayData['is_active']),
                ]
            );
        }

        return redirect()->to(route('dashboard') . '#jadwal')->with('success', 'Jadwal operasional berhasil disimpan!');
    }
}