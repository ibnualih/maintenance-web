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
        Schema::create('analisa_fuels', function (Blueprint $table) {
            $table->id();
            $table->string('status');                       // Kolom untuk status (normal, caution, critical)
            $table->string('lab_number')->unique();         // Kolom untuk lab number yang unik
            $table->string('customer_name');                // Kolom untuk nama customer
            $table->string('branch');                       // Kolom untuk branch (cabang)
            $table->date('sample_date');                    // Kolom untuk tanggal sampel
            $table->date('report_date');                    // Kolom untuk tanggal laporan
            $table->string('unit');                          // Kolom untuk unit
            $table->string('type_unit');                    // Kolom untuk tipe unit
            $table->string('code_unit');                    // Tambahkan kolom untuk kode unit di sini
            $table->string('serial_number')->unique();      // Kolom untuk serial number yang unik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisa_fuels');
    }
};
