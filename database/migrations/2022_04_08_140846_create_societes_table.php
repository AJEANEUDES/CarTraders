<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocietesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societes', function (Blueprint $table) {
            $table->bigIncrements('id_societe');
            $table->string('nom_societe', 100);
            $table->string('adresse_societe', 100);
            $table->string('telephone_societe1', 100);
            $table->string('telephone_societe2', 100)->nullable();
            $table->string('slug_societe');
            $table->string('code_societe')->unique();
            $table->boolean('status_societe')->default(true);

            
            $table->bigInteger('parking_id')->unsigned();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('societes');
    }
}
