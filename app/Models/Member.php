<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'group_id',
        'review',
        'is_creator',
        'is_mentor',
        'status'
    ];
}
