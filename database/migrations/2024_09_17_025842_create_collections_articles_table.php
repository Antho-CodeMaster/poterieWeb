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
        Schema::create('collections_articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_collection')->unsigned();
            $table->bigInteger('id_article')->unsigned();
            $table->timestamps();
        });

        Schema::table('collections_articles', function (Blueprint $table) {
            $table->foreign('id_collection')->references('id_collection')->on('collections');
            $table->foreign('id_article')->references('id_article')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections_articles');
    }
};
