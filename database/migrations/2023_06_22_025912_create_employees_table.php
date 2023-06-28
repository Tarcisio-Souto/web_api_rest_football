<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('age');
            $table->tinyInteger('genre');
            $table->string('image')->nullable();
            $table->integer('teams_id')->unsigned();
            $table->foreign('teams_id')
                  ->references('id')
                  ->on('teams')
                  ->onDelete('cascade');
            $table->integer('positions_id');
            $table->foreign('positions_id')
                  ->references('id')
                  ->on('positions')
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
        Schema::dropIfExists('employees');
    }
}
