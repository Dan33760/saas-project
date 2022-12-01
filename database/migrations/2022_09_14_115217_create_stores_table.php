<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->nullOnDelete()
                    ->constrained()
                    ->comment('User Id');
            $table->string('name_store')->comment('Designation du store');
            $table->string('url_site')->comment('Site Web du store');
            $table->string('url_affiliation')->comment('Lien d\'affiliation');
            $table->string('email_notification')->comment('Email Notification');
            $table->string('email_assistance')->comment('Email Assistance');
            $table->tinyInteger('status')->default(0)->comment('0: Non Actif, 1: Actif');
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
        Schema::dropIfExists('stores');
    }
}
