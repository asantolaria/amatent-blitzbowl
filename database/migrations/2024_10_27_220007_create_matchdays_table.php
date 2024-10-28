<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchdaysTable extends Migration
{
    public function up()
    {
        Schema::create('matchdays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained('leagues')->onDelete('cascade'); // Relación con liga
            $table->date('date');
            $table->string('description')->nullable();
            $table->integer('round_number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matchdays');
    }
}
