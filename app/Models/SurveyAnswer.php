<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    public $fillable = [
        'question_id',
        'account_id',
        'content'
    ];

    public function surveyQuestion()
    {
        return $this->belongsTo(SurveyQuestion::class, 'id', 'question_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'id', 'account_id');
    }
}
