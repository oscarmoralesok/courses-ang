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
        Schema::create('courses', function (Blueprint $table) {
            $table -> id();

            $table -> string('name');
            $table -> string('slug') -> unique();
            $table -> string('cover');
            $table -> text('excerpt') -> nullable();
            $table -> text('description') -> nullable();

            $table -> float('price_ars', 20, 2) -> nullable();
            $table -> float('price_usd', 20, 2) -> nullable();

            $table -> boolean('suscription_enable') -> default(1);
            $table -> boolean('status') -> default(0);

            $table -> date('posted_at');
            $table -> softDeletes();
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
        Schema::dropIfExists('courses');
    }
};
