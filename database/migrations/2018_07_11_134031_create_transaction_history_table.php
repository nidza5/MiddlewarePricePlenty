<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TransactionHistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uniqueIdentifier');
            $table->dateTime('time');
            $table->string('status');
            $table->string('note');
            $table->integer('totalCount');
            $table->integer('successCount');
            $table->integer('failedCount');
            $table->string('type');
            $table->string('priceMonitorContractId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TransactionHistory');
    }
}
