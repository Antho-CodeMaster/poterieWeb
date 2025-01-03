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
        Schema::create('artistes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_artiste');
            $table->bigInteger('id_user')->unsigned();
            $table->string('nom_artiste')->nullable();
            $table->string('path_photo_profil')->nullable()->default('default_artiste.png');
            $table->boolean('is_etudiant');
            $table->boolean('actif');
            $table->string('description')->nullable();
            $table->string('couleur_banniere')->default('neutral-500');
            $table->timestamps();

            //Pour Stripe
            $table->string('stripe_acc')->nullable();
        });

        Schema::table('artistes', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artistes');
    }
};
