<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignmarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('attendance');
            $table->integer('class_test');
            $table->integer('assignment_marks');
            $table->integer('midterm');
            $table->integer('final');
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
        Schema::dropIfExists('assignmarks');
    }
}
