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
        Schema::create('signalements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_signalement');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_article')->unsigned();
            $table->string('description');
            $table->boolean('actif');
            $table->timestamps();
        });

        Schema::table('signalements', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_article')->references('id_article')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
