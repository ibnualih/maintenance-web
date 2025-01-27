<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('swing_circles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('unit_model');
            $table->string('unit_code');
            $table->integer('hm');
            $table->date('last_update');
            $table->float('peak_value');
            $table->float('front_value');
            $table->string('front_picture')->nullable();
            $table->float('rear_value');
            $table->string('rear_picture')->nullable();
            $table->string('level_grease_picture')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swing_circles');
    }
};
