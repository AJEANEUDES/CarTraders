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
            $table->bigIncrements('id_parking');
            $table->string('nom_parking', 100);
            $table->string('slug_parking');
            $table->string('code_parking')->unique();
            $table->boolean('status_parking')->default(true);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('parkings');
    }
}
