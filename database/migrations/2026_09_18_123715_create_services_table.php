<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // ID akun MUA
            $table->string('title'); // Contoh: Makeup Wisuda Natural
            $table->string('category'); // wedding, graduation, photoshoot, dll.
            $table->decimal('price', 12, 2); // Tarif, misal: 350000
            $table->integer('duration_minutes')->default(120); // Durasi rias dalam menit
            $table->text('description')->nullable(); // Keterangan (fasilitas bulu mata, hijab, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
