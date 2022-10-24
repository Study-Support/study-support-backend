<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Role extends Model
{
  use HasFactory;

  protected $fillable = [
    'account_id',
    'role_id'
  ];
}
