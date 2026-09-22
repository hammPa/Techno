<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mua_profiles', function (Blueprint $table) {
            $table->string('id_card_url')->nullable()->after('instagram_username');
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])
                  ->default('unverified')
                  ->after('id_card_url');
            $table->text('rejection_reason')->nullable()->after('verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('mua_profiles', function (Blueprint $table) {
            $table->dropColumn(['id_card_url', 'verification_status', 'rejection_reason']);
        });
    }
};