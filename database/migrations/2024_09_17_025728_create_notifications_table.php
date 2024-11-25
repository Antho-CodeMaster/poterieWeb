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
        Schema::create('notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_notification');
            $table->tinyInteger('id_type')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->dateTime('date');
            $table->string('message');
            $table->string('lien')->nullable();
            $table->boolean('visible');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('id_type')->references('id_type')->on('types_notification');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
