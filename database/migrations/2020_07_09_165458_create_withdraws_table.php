<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('payment')->default(0);
            $table->integer('investment')->default(0);
            $table->integer('payer')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->boolean('paid')->default(false);
            $table->boolean('complete_matched')->default(false);
            $table->boolean('submitted_payment')->default(false);
            $table->dateTime('mature_date', 0)->default(now());
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
        Schema::dropIfExists('withdraws');
    }
}
