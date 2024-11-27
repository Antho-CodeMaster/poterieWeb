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
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_article');
            $table->bigInteger('id_artiste')->unsigned();
            $table->tinyInteger('id_etat')->unsigned();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->double('prix');
            $table->float('hauteur', 2)->nullable();
            $table->float('largeur', 2)->nullable();
            $table->float('profondeur', 2)->nullable();
            $table->float('poids', 2)->nullable();
            $table->smallInteger('quantite_disponible');
            $table->boolean('is_en_vedette');
            $table->boolean('is_sensible');
            $table->boolean('is_alimentaire');
            $table->boolean('is_unique');
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('id_artiste')->references('id_artiste')->on('artistes');
            $table->foreign('id_etat')->references('id_etat')->on('etats_article');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
