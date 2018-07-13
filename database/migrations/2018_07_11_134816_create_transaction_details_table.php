<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TransactionDetails', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('time');
            $table->string('productId');
            $table->string('status');
            $table->string('gtin');
            $table->string('productName');
            $table->string('note')->nullable();
            $table->boolean('isUpdated')->default(false);
            $table->string('referencePrice')->nullable();
            $table->string('minPrice')->nullable();
            $table->string('maxPrice')->nullable();
            $table->integer('transactionId');
            $table->string('transactionUniqueIdentifier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TransactionDetails');
    }
}
