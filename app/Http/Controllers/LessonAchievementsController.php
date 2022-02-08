<?php

namespace App\Http\Controllers;

use App\Models\LessonAchievements;
use Illuminate\Http\Request;
use App\Http\Controllers\LessonTestsController;

class LessonAchievementsController extends Controller
{
    public function update_score(){
        LessonAchievements::create([
            'username'=>auth()->user()->username,
            'course_id'=>1,
            'course_name'=>2,
            'lesson_id'=>3,
            'mark'=>4
        ]);
    }
}
