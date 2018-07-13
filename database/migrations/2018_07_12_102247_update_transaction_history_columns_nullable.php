<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionHistoryColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactionhistory', function (Blueprint $table) {
            $table->dateTime('time')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('note')->nullable()->change();
            $table->integer('totalCount')->nullable()->change();
            $table->integer('successCount')->nullable()->change();
            $table->integer('failedCount')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('priceMonitorContractId')->nullable()->change();
            $table->string('uniqueIdentifier')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dateTime('time')->change();
        $table->string('status')->change();
        $table->string('note')->change();
        $table->integer('totalCount')->change();
        $table->integer('successCount')->change();
        $table->integer('failedCount')->change();
        $table->string('type')->change();
        $table->string('priceMonitorContractId')->change();
        $table->string('uniqueIdentifier')->change();
    }
}
