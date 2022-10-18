<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
  use HasApiTokens, HasFactory;

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

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id');
  }
}
