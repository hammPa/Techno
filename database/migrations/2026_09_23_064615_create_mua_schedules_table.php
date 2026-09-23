<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mua_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // 0 = Minggu, 1 = Senin, ... 6 = Sabtu (standar Carbon PHP)
            $table->unsignedTinyInteger('day_of_week');
            $table->time('start_time')->default('08:00:00');
            $table->time('end_time')->default('17:00:00');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Memastikan 1 MUA hanya memiliki 1 entri pengaturan per hari
            $table->unique(['user_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mua_schedules');
    }
};