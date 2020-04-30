<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('island')->nullable();
            $table->string('zip')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longtext('ordernotes')->nullable();
            $table->integer('payment_status')->default('0');
            $table->string('payment_method')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('total')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
