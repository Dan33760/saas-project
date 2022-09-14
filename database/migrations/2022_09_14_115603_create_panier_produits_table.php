<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanierProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panier_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panier_id')->constrained()->comment('Panier Id');
            $table->foreignId('produit_id')->constrained()->comment('Produit Id');
            $table->integer('qu_produit_pa')->comment('Quantite produit Panier');
            $table->decimal('prix_total')->comment('Prix total du Panier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panier_produits');
    }
}
