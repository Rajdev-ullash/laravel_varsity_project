<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachergivenmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachergivenmarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('marks_title');
            $table->json('assign_marks');
            $table->json('given_marks');
            $table->integer('total');
            $table->boolean('done')->default(false);
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->unsignedBigInteger('section_name');
            $table->foreign('section_name')->references('id')->on('sections');
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
        Schema::dropIfExists('teachergivenmarks');
    }
}
