<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  use HasFactory;

  public $fillable = [
    'topic',
    'information',
    'time_study',
    'subject_id',
    'faculty_id',
    'location_study',
    'status',
    'self_study'
  ];

  public function accounts()
  {
    return $this->belongsToMany(Account::class, 'members', 'group_id', 'account_id')
      ->withPivot('is_creator', 'is_mentor', 'status');
  }

  public function mentor()
  {
    return $this->accounts()->wherePivot('is_mentor', '=', '1');
  }

  public function members()
  {
    return $this->accounts()->wherePivot('is_mentor', '=', '0');
  }

  public function creator()
  {
    return $this->accounts()->wherePivot('is_creator', '=', '1');
  }

  public function getCreatorAttribute()
  {
    return $this->creator()->first();
  }

  public function subject()
  {
    return $this->hasOne(Subject::class, 'id', 'subject_id');
  }

  public function faculty()
  {
    return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
  }

  public function mentorAccepted()
  {
    return $this->mentor()->wherePivot('status', '=', '1');
  }

  public function getMentorAcceptedAttribute()
  {
    return $this->mentorAccepted()->first();
  }

  public function membersAccepted()
  {
    return $this->members()->wherePivot('status', '=', '1');
  }

  public function mentorWaiting()
  {
    return $this->mentor()->wherePivot('status', '=', '0');
  }

  public function membersWaiting()
  {
    return $this->members()->wherePivot('status', '=', '0');
  }

  public function surveyQuestions()
  {
    return $this->hasMany(SurveyQuestion::class, 'group_id', 'id');
  }

  public function surveyAnswers()
  {
    return $this->hasManyThrough(
        SurveyAnswer::class,
        SurveyQuestion::class,
        'group_id',
        'question_id',
        'id',
        'id'
    );
  }
}
