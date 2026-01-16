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
    Schema::table('angpaos', function (Blueprint $table) {
        // Tipe: money atau item
        $table->string('reward_type')->default('money')->after('code');
        // Nama barang (jika tipe item) atau nominal (jika money) dalam bentuk string
        $table->string('reward_name')->after('reward_type');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angpaos', function (Blueprint $table) {
            //
        });
    }
};
