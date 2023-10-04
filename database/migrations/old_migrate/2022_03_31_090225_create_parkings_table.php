<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->increments('id_parking');
            $table->string('nom_parking', 50);
            $table->string('adresse_parking', 50);
            $table->string('telephone_parking1', 50);
            $table->string('telephone_parking2', 50)->nullable();
            $table->string('proprietaire_parking', 50);
            $table->string('slug_parking');
            $table->string('code_parking')->unique();
            $table->boolean('status_parking')->default(true);
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
                ->on('users')
                ->references('id_utilisateur')
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
        Schema::dropIfExists('parkings');
    }
}
