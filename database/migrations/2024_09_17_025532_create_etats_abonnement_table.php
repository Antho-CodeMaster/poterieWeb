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
        Schema::create('etats_abonnement', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id_etat');
            $table->timestamps();
            $table->string('etat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etats_abonnement');
    }
};
