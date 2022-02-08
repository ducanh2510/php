<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('course_id');
            $table->string('course_name');
            $table->float('midterm_score')->nullable();
            $table->float('final_score')->nullable();
            $table->float('mark')->nullable();
            $table->string('achievement')->nullable();
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
        Schema::dropIfExists('course_achievements');
    }
}
