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
        Schema::create('demandes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_demande');
            $table->tinyInteger('id_type')->unsigned();
            $table->tinyInteger('id_etat')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->string('raison_refus')->nullable();
            $table->timestamps();
        });

        Schema::table('demandes', function (Blueprint $table) {
            $table->foreign('id_type')->references('id_type')->on('types_demande');
            $table->foreign('id_etat')->references('id_etat')->on('etats_demande');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
