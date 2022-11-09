<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssigncoursemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigncoursemarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('marks_title');
            $table->integer('assign_marks');
            $table->integer('given_marks');
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
        Schema::dropIfExists('assigncoursemarks');
    }
}
