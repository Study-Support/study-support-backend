<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Account extends Authenticatable
{
  use HasFactory, HasApiTokens;

  protected $fillable = [
    'email',
    'password',
    'role_id',
    'is_active'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function userInfo()
  {
    return $this->hasOne(UserInfo::class, 'account_id');
  }

  public function roles()
  {
    return $this->belongsToMany(Role::class, 'account_role', 'role_id', 'account_id');
  }

  public function setPasswordAttribute($value)
  {
    return $this->attributes['password'] = Hash::make($value);
  }

  public function mentorInfo()
  {
    return $this->hasOne(MentorInfo::class, 'account_id');
  }

  public function accountInGroup()
  {
    return $this->belongsToMany(Group::class, 'members', 'group_id', 'account_id')
      ->withPivot('rating', 'is_creator', 'review', 'is_mentor', 'status');
  }

  public function memberInGroup()
  {
    return $this->accountInGroup()->wherePivot('is_mentor', '=', '0');
  }

  public function mentorInGroup()
  {
    return $this->accountInGroup()->wherePivot('is_mentor', '=', '1');
  }

  public function creatorInGroup()
  {
    return $this->accountInGroup()->wherePivot('is_creator', '=', '1');
  }
}
