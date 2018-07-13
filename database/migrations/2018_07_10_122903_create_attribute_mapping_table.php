<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AttributeMapping', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attributeCode');
            $table->string('priceMonitorCode');
            $table->string('operand');
            $table->string('value');
            $table->integer('contractId');
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
        Schema::dropIfExists('AttributeMapping');
    }
}
