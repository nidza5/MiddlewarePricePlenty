<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceMonitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PriceMonitorQueue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('queueName');
            $table->dateTime('reservationTime');
            $table->integer('attempts');
            $table->longText('payload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PriceMonitorQueue');
    }
}
