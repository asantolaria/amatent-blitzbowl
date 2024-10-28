<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matchday_id')->constrained()->onDelete('cascade'); // Relación con la jornada
            $table->foreignId('team_a_id')->constrained('teams')->onDelete('cascade'); // Equipo A
            $table->foreignId('team_b_id')->constrained('teams')->onDelete('cascade'); // Equipo B
            $table->integer('score_a')->default(0); // Puntaje del equipo A
            $table->integer('score_b')->default(0); // Puntaje del equipo B
            $table->integer('touchdowns_a')->default(0); // Touchdowns del equipo A
            $table->integer('touchdowns_b')->default(0); // Touchdowns del equipo B
            $table->integer('injuries_a')->default(0); // Lesiones del equipo A
            $table->integer('injuries_b')->default(0); // Lesiones del equipo B
            $table->integer('cards_a')->default(0); // Tarjetas del equipo A
            $table->integer('cards_b')->default(0); // Tarjetas del equipo B
            $table->text('notes')->nullable(); // Notas del partido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
