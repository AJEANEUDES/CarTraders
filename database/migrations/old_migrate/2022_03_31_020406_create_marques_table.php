<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marques', function (Blueprint $table) {
            $table->increments('id_marque');
            $table->string('nom_marque', 50);
            $table->string('slug_marque');
            $table->string('code_marque')->unique();
            $table->boolean('status_marque')->default(true);
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')
                ->on('users')
                ->references('id_user')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marques');
    }
}
