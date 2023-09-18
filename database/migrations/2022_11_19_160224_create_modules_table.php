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
        Schema::create('modules', function (Blueprint $table) {
            $table -> id();

            $table -> string('name');
            $table -> string('slug') -> unique();

            $table -> tinyInteger('number');

            $table -> unsignedBigInteger('course_id');
            $table -> foreign('course_id') -> references('id') -> on('courses') -> onDelete('cascade');

            $table -> timestamp('posted_at');
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
        Schema::dropIfExists('modules');
    }
};
