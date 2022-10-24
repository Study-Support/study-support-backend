<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorInfo extends Model
{
  use HasFactory;

  public $fillable = [
    'account_id',
    'cv_link',
    'smart_banking',
    'rating',
    'status'
  ];

  public function account()
  {
    return $this->belongsTo(Account::class, 'account_id');
  }

  public function subjects()
  {
    return $this->belongsToMany(Subject::class, 'mentor_subject', 'subject_id', 'mentor_id');
  }
}
