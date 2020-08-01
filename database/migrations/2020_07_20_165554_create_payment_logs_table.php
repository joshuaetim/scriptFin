<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user')->default(0);
            $table->integer('receiver')->default(0);
            $table->string('method');
            $table->string('proof')->nullable();
            $table->integer('investment')->default(0);
            $table->bigInteger('withdraw')->default(0);
            $table->string('bank');
            $table->string('account_number');
            $table->string('account_name');
            $table->string('depositor_name');
            $table->string('payment_location');
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
        Schema::dropIfExists('payment_logs');
    }
}
