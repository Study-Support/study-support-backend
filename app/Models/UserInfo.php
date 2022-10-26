<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class UserInfo extends Model
{
  use HasFactory, Rateable;

  protected $table = 'user_information';

  public $fillable = [
    'account_id',
    'full_name',
    'address',
    'gender',
    'phone_number',
    'birthday',
    'avatar_url',
    'faculty_id',
  ];

  public function account()
  {
    return $this->belongsTo(Account::class, 'account_id');
  }

  public function faculty()
  {
    return $this->belongsTo(Faculty::class, 'id', 'faculty_id');
  }
}
