<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionDetailsColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactiondetails', function (Blueprint $table) {
            $table->dateTime('time')->nullable()->change();
            $table->string('productId')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('gtin')->nullable()->change();
            $table->string('productName')->nullable()->change();
            $table->integer('transactionId')->nullable()->change();

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
        $table->string('productId')->change();
        $table->string('status')->change();
        $table->string('gtin')->change();
        $table->string('productName')->change();
        $table->integer('transactionId')->change();
    }
}
