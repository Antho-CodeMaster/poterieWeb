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
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_transaction');
            $table->bigInteger('id_commande')->unsigned();
            $table->bigInteger('id_article')->unsigned();
            $table->tinyInteger('id_etat')->unsigned();
            $table->smallInteger('id_compagnie')->unsigned()->nullable();
            $table->smallInteger('quantite');
            $table->double('prix_unitaire')->nullable();
            $table->date('date_reception_prevue')->nullable();
            $table->date('date_reception_effective')->nullable();
            $table->string('code_ref_livraison')->nullable();
            $table->string('trackingId_easypost')->nullable();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('id_commande')->references('id_commande')->on('commandes');
            $table->foreign('id_article')->references('id_article')->on('articles');
            $table->foreign('id_etat')->references('id_etat')->on('etats_transaction');
            $table->foreign('id_compagnie')->references('id_compagnie')->on('compagnies_livraison');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
