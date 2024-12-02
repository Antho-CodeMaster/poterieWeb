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
        Schema::create('articles_non_recus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_signalement');
            $table->bigInteger('id_transaction')->unsigned();
            $table->string('description')->nullable();
            $table->boolean('actif');
            $table->timestamps();
        });

        Schema::table('articles_non_recus', function (Blueprint $table) {
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles_non_recus');
    }
};
