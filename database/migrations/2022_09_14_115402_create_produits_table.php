<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                    ->cascadeOnDelete()
                    ->constrained()
                    ->comment('Id Store');
            $table->string('nom_produit')->comment('Designation du Produit');
            $table->decimal('pu_produit', 8,2)->comment('Prix Unitaire du produit');
            $table->bigInteger('qu_produit')->comment('Quantite du Produit');
            $table->integer('seuil')->comment('Quantite minimal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}
