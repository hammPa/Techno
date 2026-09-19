<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi enum role di tabel users agar mendukung 'admin'
        // Jika menggunakan MySQL:
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'mua', 'admin') DEFAULT 'client'");

        // 2. Modifikasi tabel bookings: tambah completion_code & payment_status, serta sesuaikan enum status
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('completion_code', 4)->nullable()->after('status');
            $table->enum('payment_status', [
                'unpaid',
                'waiting_verification',
                'dp_paid',
                'fully_paid',
                'released_to_mua'
            ])->default('unpaid')->after('completion_code');
        });

        // Modifikasi enum status bookings untuk alur baru
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'waiting_payment', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending'");

        // 3. Buat tabel payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Klien yang transfer
            $table->enum('type', ['dp', 'full'])->default('full');
            $table->decimal('amount', 12, 2);
            $table->string('bank_name'); // misal: BCA, Mandiri, Dana, dll
            $table->string('sender_name');
            $table->string('proof_image'); // path screenshot transfer
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['completion_code', 'payment_status']);
        });

        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending'");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'mua') DEFAULT 'client'");
    }
};