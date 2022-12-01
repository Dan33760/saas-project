<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->cascadeOnDelete()
                    ->constrained()
                    ->comment('User Id');
            $table->foreignId('store_id')
                    ->cascadeOnDelete()
                    ->constrained()
                    ->comment('Store Id');
            $table->boolean('active')->default(1)->comment('0: Non Active, 1: Active');
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
        Schema::dropIfExists('store_users');
    }
}
