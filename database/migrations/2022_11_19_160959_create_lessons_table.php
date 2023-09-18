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
        Schema::create('lessons', function (Blueprint $table) {
            $table -> id();

            $table -> string('title');
            $table -> string('slug') -> unique();
            $table -> text('description');
            $table -> string('duration') -> nullable();

            $table -> tinyInteger('number');

            $table -> unsignedBigInteger('module_id');
            $table -> foreign('module_id') -> references('id') -> on('modules') -> onDelete('cascade');

            $table -> unsignedBigInteger('course_id');
            $table -> foreign('course_id') -> references('id') -> on('courses') -> onDelete('cascade');

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
        Schema::dropIfExists('lessons');
    }
};
