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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_abonnement');
            $table->bigInteger('id_artiste')->unsigned();
            $table->tinyInteger('id_etat')->unsigned();
            $table->double('prix_paye');
            $table->dateTime('date');
            $table->timestamps();
        });

        Schema::table('abonnements', function (Blueprint $table) {
            $table->foreign('id_artiste')->references('id_artiste')->on('artistes');
            $table->foreign('id_etat')->references('id_etat')->on('etats_abonnement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
