<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sender_id');
            $table->longText('message');
            $table->string('phone_number');

            $table->integer('success')->default('0');
            $table->integer('error')->default('0');
            $table->string('error_message')->nullable();

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
        Schema::dropIfExists('single_messages');
    }
}
