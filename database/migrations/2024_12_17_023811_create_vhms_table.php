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
        Schema::create('vhms', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('sn');
            $table->integer('hm');
            $table->float('blowby_max');
            $table->float('boost_press_max');
            $table->float('exh_temp_lf_max');
            $table->float('exh_temp_lr_max');
            $table->float('exh_temp_rf_max');
            $table->float('exh_temp_rr_max');
            $table->float('eng_oil_press_hmin');
            $table->float('eng_oil_press_lmin');
            $table->float('coolant_temp_max');
            $table->float('eng_oil_temp_max');
            $table->float('tm_oil_temp_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vhms');
    }
};
