<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenTracksTable extends Migration
{
    public function up()
    {
        Schema::create('komponen_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('code');
            $table->integer('total_phenomena');
            $table->string('status'); // 'caution' atau 'critical'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('komponen_tracks');
    }
}

