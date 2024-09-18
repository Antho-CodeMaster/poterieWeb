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
        Schema::create('reseaux_artistes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('id_reseau')->unsigned();
            $table->bigInteger('id_artiste')->unsigned();
            $table->string('username');
            $table->timestamps();
        });

        Schema::table('reseaux_artistes', function (Blueprint $table) {
            $table->foreign('id_reseau')->references('id_reseau')->on('reseaux');
            $table->foreign('id_artiste')->references('id_artiste')->on('artistes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseaux_artistes');
    }
};
