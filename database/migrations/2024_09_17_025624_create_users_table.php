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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_civique', 6)->nullable();
            $table->string('rue')->nullable();
            $table->char('code_postal', 6)->nullable();
            $table->smallInteger('id_ville')->unsigned()->nullable();
            $table->char('telephone', 10)->nullable();
            $table->boolean('contenu_sensible')->default(0);
            $table->tinyInteger('id_question_securite')->unsigned();
            $table->string('reponse_question');
            $table->boolean('active');
            $table->boolean('units');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->string('google2fa_secret')->nullable();
            $table->boolean('uses_two_factor_auth')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_ville')->references('id_ville')->on('villes');
            $table->foreign('id_question_securite')->references('id_question')->on('questions_securite');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
