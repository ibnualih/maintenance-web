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
        Schema::table('wheel_brakes', function (Blueprint $table) {
            $table->string('rlh_picture')->nullable();
            $table->string('lrh_picture')->nullable();
            $table->string('llh_picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wheel_brakes', function (Blueprint $table) {
            $table->dropColumn('rlh_picture');
            $table->dropColumn('lrh_picture');
            $table->dropColumn('llh_picture');
        });
    }
};
