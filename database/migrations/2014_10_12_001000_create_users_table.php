<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('userID')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->boolean('special')->default(0);
            $table->integer('level')->default(0);
            $table->boolean('matched')->default(false);
            $table->integer('multiple_matched')->default(0);
            $table->string('account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->bigInteger('account_number')->default(0);
            $table->bigInteger('pending_payout')->default(0);
            $table->bigInteger('balance')->default(0);
            $table->bigInteger('referral_balance')->default(0);
            $table->string('referral')->nullable();
            $table->boolean('profile_complete')->default(false);
            $table->boolean('blocked')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
