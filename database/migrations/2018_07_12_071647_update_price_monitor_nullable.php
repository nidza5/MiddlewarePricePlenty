<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePriceMonitorNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricemonitorqueue', function (Blueprint $table) {
            $table->dateTime('reservationTime')->nullable()->change();
            $table->integer('attempts')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pricemonitorqueue', function (Blueprint $table) {
            $table->dateTime('reservationTime')->change();
            $table->integer('attempts')->change();
        });
    }
}
