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
        Schema::create('analisa_paps', function (Blueprint $table) {
            $table->id();
            $table->string('grouploc', 50)->nullable();
            $table->string('ADD_CODE', 50)->nullable();
            $table->string('branch', 50)->nullable();
            $table->string('Lab_No', 50)->nullable();
            $table->date('SAMPL_DT1')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->unsignedBigInteger('ComponentID')->nullable();
            $table->string('MODEL', 50)->nullable();
            $table->string('OIL_TYPE', 50)->nullable();
            $table->integer('HRS_KM_TOT')->nullable();
            $table->boolean('oil_change')->nullable();
            $table->float('visc_40', 6, 2)->nullable();  // Mengurangi presisi float
            $table->string('TBN_CODE', 50)->nullable();
            $table->float('CALCIUM', 6, 2)->nullable();
            $table->string('ZINC_CODE', 50)->nullable();
            $table->string('WATER', 50)->nullable();
            $table->float('SODIUM', 6, 2)->nullable();
            $table->float('SILICON', 6, 2)->nullable();
            $table->float('IRON', 6, 2)->nullable();  // Ukuran lebih optimal
            $table->string('FE_CODE', 50)->nullable();
            $table->string('LEAD', 50)->nullable();
            $table->string('RECOMM1', 255)->nullable(); // Mengubah panjang menjadi 255
            $table->text('Notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisa_paps');
    }
};
