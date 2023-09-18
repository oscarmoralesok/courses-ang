<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_payments', function (Blueprint $table) {
            $table -> id();

            $table -> string('payer_email') -> nullable();
            $table -> string('gateway');
            $table -> string('payment_id') -> nullable();
            $table -> string('token');

            $table -> float('amount', 20, 2);

            $table -> boolean('status') -> default(1);

            $table -> unsignedBigInteger('user_id');
            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');

            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membership_payments');
    }
};
