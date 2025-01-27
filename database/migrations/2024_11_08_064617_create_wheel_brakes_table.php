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
        Schema::create('wheel_brakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('unit_code');
            $table->integer('hm');
            $table->integer('ed');
            $table->date('last_date');
            // Last
            $table->float('flh_rgauge')->nullable();
            $table->float('flh_tbase')->nullable();
            $table->float('frh_rgauge')->nullable();
            $table->float('frh_tbase')->nullable();
            $table->float('rlh_rgauge')->nullable();
            $table->float('rlh_tbase')->nullable();
            $table->float('rrh_rgauge')->nullable();
            $table->float('rrh_tbase')->nullable();
            $table->string('picture')->nullable();
            $table->string('status')->default('pending');
            // // Resume
            // $table->date('resume_date')->nullable();
            // $table->text('remark')->nullable();
            // $table->float('resume_flh_rgauge')->nullable();
            // $table->float('resume_flh_tbase')->nullable();
            // $table->float('resume_frh_rgauge')->nullable();
            // $table->float('resume_frh_tbase')->nullable();
            // $table->float('resume_rlh_rgauge')->nullable();
            // $table->float('resume_rlh_tbase')->nullable();
            // $table->float('resume_rrh_rgauge')->nullable();
            // $table->float('resume_rrh_tbase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wheel_brakes');
    }
};
