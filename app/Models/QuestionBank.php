<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class QuestionBank extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'course_id',
        'subject_name',
        'question',
        'choose_1',
        'choose_2',
        'choose_3',
        'choose_4',
        'answer',
        'point',
    ];
}
