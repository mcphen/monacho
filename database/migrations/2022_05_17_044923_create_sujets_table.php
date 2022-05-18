<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sujets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('intitulé');
            $table->string('file_pdf');
            $table->foreignId('annee_id')->constrained('annees')->onDelete('cascade');
            $table->foreignId('examen_id')->constrained('examens')->onDelete('cascade');
            $table->foreignId('type_session_id')->constrained('type_sessions')->onDelete('cascade');
            $table->foreignId('type_sujet_id')->constrained('type_sujets')->onDelete('cascade');
            $table->foreignId('serie_id')->constrained('series')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
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
        Schema::dropIfExists('sujets');
    }
};
