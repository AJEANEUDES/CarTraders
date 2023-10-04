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
            $table->bigIncrements('id');
            $table->string('code_user')->unique();
            $table->string('nom_user', 50);
            $table->string('prenom_user', 50);
            $table->string('email_user', 50)->unique();
            $table->string('telephone_user', 50)->unique();
            $table->string('prefix_user', 10)->nullable();
            $table->string('adresse_user', 50);
            $table->string('roles_user', 3);
            $table->boolean('status_user')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('pays_user', 50)->nullable();
            $table->string('ville_user', 50)->nullable();
            $table->string('quartier_user', 50)->nullable();
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
