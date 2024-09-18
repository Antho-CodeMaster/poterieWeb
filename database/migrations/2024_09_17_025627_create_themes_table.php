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
        Schema::create('themes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id_theme');
            $table->timestamps();
            $table->char('arriere_plan', 6);
            $table->char('en_vedette', 6);
            $table->char('article', 6);
            $table->char('bouton', 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
