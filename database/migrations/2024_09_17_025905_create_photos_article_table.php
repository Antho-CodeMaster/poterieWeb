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
        Schema::create('photos_article', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_photo');
            $table->bigInteger('id_article')->unsigned();
            $table->string('path');
            $table->timestamps();
        });

        Schema::table('photos_article', function (Blueprint $table) {
            $table->foreign('id_article')->references('id_article')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos_article');
    }
};
