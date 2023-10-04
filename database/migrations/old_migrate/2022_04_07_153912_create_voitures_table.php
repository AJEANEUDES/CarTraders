<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voitures', function (Blueprint $table) {
            $table->increments('id_voiture');
            $table->string('code_voiture')->unique();
            $table->string('slug_voiture');
            $table->string('prix_voiture');
            $table->string('kilometrage_voiture');
            $table->string('interieur_voiture');
            $table->string('exterieur_voiture');
            $table->string('puissance_voiture');
            $table->string('nbres_place_voiture');
            $table->string('date_mise_circul_voiture');
            $table->string('carburant_voiture');
            $table->string('boite_vitesse_voiture');
            $table->string('annee_voiture');
            $table->string('image_voiture');
            $table->boolean('status_voiture')->default(true);
            $table->integer('marque_id')->unsigned();
            $table->integer('modele_id')->unsigned();
            $table->integer('parking_id')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('marque_id')
                ->on('marques')
                ->references('id_marque')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('modele_id')
                ->on('modeles')
                ->references('id_modele')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('parking_id')
                ->on('parkings')
                ->references('id_parking')
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
        Schema::dropIfExists('voitures');
    }
}
