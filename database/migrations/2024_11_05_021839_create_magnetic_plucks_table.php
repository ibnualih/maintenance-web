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
        Schema::create('magnetic_plucks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('unit_model');
            $table->string('unit_code');
            $table->integer('hm');
            $table->integer('ed');
            $table->date('last_update');
            $table->string('component');
            $table->string('rating');
            $table->string('picture')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magnetic_plucks');
    }
};
