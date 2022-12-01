<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_ref')->comment('Code de reference');
            $table->string('fname')->comment('First Name');
            $table->string('lname')->comment('Last Name');
            $table->string('email')->unique()->comment('Adresse Email');
            $table->timestamp('email_verified_at')->nullable()->comment('Adresse Email de verification');
            $table->string('password')->comment('Password');
            $table->foreignId('ville_id')
                    ->nullable()
                    ->constrained()
                    ->cascadeOnDelete()
                    ->comment('Id de la ville');
            $table->string('tel')->nullable()->unique()->comment('Numero de telephone');
            $table->text('adresse')->nullable()->comment('Adresse utilisateur');
            $table->string('code_postal')->nullable()->comment('Code Postal');
            $table->date('anniversaire')->nullable()->comment('Date de Naissance');
            $table->enum('genre', ['Homme', 'Femme'])->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Non actif, 1: Actif');
            $table->enum('isAdmin', [0,1])->default(0)->comment('0: Not Admin, 1: Is Admin');
            $table->enum('isTenant', [0,1])->default(0)->comment('0: Not Tenant, 1: Is Tenant');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
