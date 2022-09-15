<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                    ->cascadeOnDelete()
                    ->constrained()
                    ->comment('Store Id');
            $table->string('description')->comment('description du document');
            $table->string('file_name')->comment('Nom du fichier');
            $table->string('file_url')->comment('Stockage du Fichier');
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
        Schema::dropIfExists('documents');
    }
}
