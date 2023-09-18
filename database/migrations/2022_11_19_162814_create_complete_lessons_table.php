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
        Schema::create('complete_lessons', function (Blueprint $table) {
            $table -> id();

            $table -> unsignedBigInteger('lesson_id');
            $table -> foreign('lesson_id') -> references('id') -> on('lessons') -> onDelete('cascade');

            $table -> unsignedBigInteger('course_id');
            $table -> foreign('course_id') -> references('id') -> on('courses') -> onDelete('cascade');

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
        Schema::dropIfExists('complete_lessons');
    }
};
