<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
           
            $table->bigIncrements('id_image');
            $table->string('path_image');
            $table->bigInteger('voiture_id')->unsigned()->nullable();
            $table->bigInteger('societe_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('voiture_id')
                ->on('voitures')
                ->references('id_voiture')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('societe_id')
                ->on('societes')
                ->references('id_societe')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->on('users')
                ->references('id')
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
        Schema::dropIfExists('images');
    }
}
