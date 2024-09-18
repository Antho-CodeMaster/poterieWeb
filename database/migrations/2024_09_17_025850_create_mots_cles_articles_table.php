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
        Schema::create('mots_cles_articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_mot_cle')->unsigned();
            $table->bigInteger('id_article')->unsigned();
            $table->timestamps();
        });

        Schema::table('mots_cles_articles', function (Blueprint $table) {
            $table->foreign('id_mot_cle')->references('id_mot_cle')->on('mots_cles');
            $table->foreign('id_article')->references('id_article')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mots_cles_articles');
    }
};
