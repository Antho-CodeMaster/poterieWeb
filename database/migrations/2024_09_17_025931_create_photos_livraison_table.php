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
        Schema::create('photos_livraison', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_photo');
            $table->bigInteger('id_transaction')->unsigned();
            $table->string('directory');
            $table->timestamps();
        });

        Schema::table('photos_livraison', function (Blueprint $table) {
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos_livraisons');
    }
};
