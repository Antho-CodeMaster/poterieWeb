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
        Schema::create('commandes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_commande');
            $table->bigInteger('id_user')->unsigned();
            $table->dateTime('date');
            $table->string('no_civique', 6);
            $table->string('rue');
            $table->char('code_postal', 6);
            $table->smallInteger('id_ville')->unsigned();
            $table->timestamps();
            $table->boolean('is_panier');
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_ville')->references('id_ville')->on('villes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
