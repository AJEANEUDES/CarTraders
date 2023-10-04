<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modeles', function (Blueprint $table) {
            $table->bigIncrements('id_modele');
            $table->string('nom_modele', 50);
            $table->string('slug_modele');
            $table->string('code_modele')->unique();
            $table->boolean('status_modele')->default(true);
            $table->bigInteger('marque_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('marque_id')
                ->on('marques')
                ->references('id_marque')
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
        Schema::dropIfExists('modeles');
    }
}
