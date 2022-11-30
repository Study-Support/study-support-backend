<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    public $fillable = [
        'group_id',
        'content'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'question_id', 'id');
    }
}
