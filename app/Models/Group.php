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
    'location_study',
    'status',
    'student_amount'
  ];

  public function accounts()
  {
    return $this->belongsToMany(Account::class, 'members', 'account_id', 'group_id')
      ->withPivot('rating', 'is_creator', 'review', 'is_mentor', 'status');
  }

  public function mentor()
  {
    return $this->accounts()->wherePivot('is_mentor','=','1');
  }

  public function members()
  {
    return $this->accounts()->wherePivot('is_mentor', '=', '0');
  }

  public function creator()
  {
    return $this->accounts()->wherePivot('is_creator', '=', '1');
  }
}
