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
        Schema::create('photos_identite', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_photo');
            $table->bigInteger('id_demande')->unsigned();
            $table->string('path');
            $table->timestamps();
        });

        Schema::table('photos_identite', function (Blueprint $table) {
            $table->foreign('id_demande')->references('id_demande')->on('demandes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos_identite');
    }
};
