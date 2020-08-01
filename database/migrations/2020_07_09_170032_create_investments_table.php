<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uniqueID')->nullable();
            $table->integer('user_id');
            $table->bigInteger('amount_offered');
            $table->bigInteger('main_offered')->default(0);
            $table->boolean('paid')->default(false);
            $table->boolean('paid_complete')->default(false);
            $table->bigInteger('amount_paid')->default(0);
            $table->bigInteger('yield')->default(0);
            $table->integer('bonus')->default(0);
            $table->integer('receiver')->default(0);
            $table->boolean('total_matched')->default(false);
            $table->boolean('withdraw')->default(false);
            $table->boolean('completed')->default(false);
            $table->dateTime('mature_date', 0)->default(now());
            $table->boolean('flagged')->default(false);
            $table->boolean('activation')->default(false);
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
        Schema::dropIfExists('investments');
    }
}
