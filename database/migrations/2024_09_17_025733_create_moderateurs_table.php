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
        Schema::create('moderateurs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_moderateur');
            $table->bigInteger('id_user')->unsigned();
            $table->boolean('is_admin');
            $table->timestamps();
        });

        Schema::table('moderateurs', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderateurs');
    }
};
