<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualGroupMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_group_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_message_id');
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
        Schema::dropIfExists('individual_group_messages');
    }
}
