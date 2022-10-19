<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
  use HasFactory;

  protected $table = 'user_information';

  public $fillable = [
    'account_id',
    'full_name',
    'address',
    'gender',
    'phone_number',
    'birthday',
    'rating',
    'avatar_url',
    'class_id',
    'faculty_id',
    'cv_link',
    'smart_banking',
    'mentor_rating'
  ];

  public function account()
  {
    return $this->belongsTo(Account::class, 'account_id');
  }

  public function faculty()
  {
    return $this->belongsTo(Faculty::class, 'faculty_id');
  }
}
