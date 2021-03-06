<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nota_id');
            $table->integer('customer_id');
            $table->enum('status', ['ordered', 'shipied', 'arrived'])->default('ordered');
            $table->integer('tool_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_shipments');
    }
}
