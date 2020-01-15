<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffeeMachinesCoffeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_machines_coffees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coffee_machine_id');
            $table->foreign('coffee_machine_id')->references('id')->on('coffee_machines');
            $table->unsignedBigInteger('coffee_id');
            $table->foreign('coffee_id')->references('id')->on('coffees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coffee_machines_coffees');
    }
}
