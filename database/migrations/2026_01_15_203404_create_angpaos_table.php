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
        Schema::create('angpaos', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // Kode Voucher (Contoh: LUNAR-A7B2X9)
            // Menggunakan index & unique agar pencarian cepat dan tidak duplikat
            $blueprint->string('code')->unique()->index();
            
            // Nominal uang (menggunakan decimal agar presisi untuk mata uang)
            $blueprint->decimal('amount', 15, 2);
            
            // Status: active, claimed, expired
            $blueprint->string('status')->default('active')->index();
            
            // Informasi Klaim
            $blueprint->foreignId('claimed_by')->nullable()->constrained('users')->onDelete('set null');
            $blueprint->timestamp('claimed_at')->nullable();
            
            // Masa Berlaku
            $blueprint->timestamp('expires_at')->nullable();
            
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angpaos');
    }
};