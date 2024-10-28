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
            $table->bigInteger('id_user')->unsigned()->nullable();
            $table->dateTime('date')->nullable();
            $table->string('no_civique', 6)->nullable();
            $table->string('rue')->nullable();
            $table->char('code_postal', 6)->nullable();
            $table->smallInteger('id_ville')->unsigned()->nullable();
            $table->timestamps();
            $table->boolean('is_panier');
            $table->string('checkout_id', 255)->nullable();
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
