<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {

            $table->bigIncrements('id_reservation');
            $table->integer('prix_reservation');
            $table->text('service_reservation')->nullable();
            $table->boolean('status_reservation')->default(false);
            $table->boolean('status_annulation')->default(false);
            $table->bigInteger('voiture_id')->unsigned();
            $table->bigInteger('societe_id')->unsigned();
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
        Schema::dropIfExists('reservations');
    }
}
