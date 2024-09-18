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
        Schema::create('mots_cles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_mot_cle');
            $table->timestamps();
            $table->string('mot_cle', 32);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mots_cles');
    }
};
