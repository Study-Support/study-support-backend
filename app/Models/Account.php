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
        return $this->belongsToMany(Group::class, 'members', 'account_id', 'group_id')
            ->withPivot('is_creator', 'is_mentor', 'status');
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

    public function memberInGroupAccepted()
    {
        return $this->memberInGroup()->wherePivot('status', '=', '1');
    }

    public function mentorInGroupAccepted()
    {
        return $this->mentorInGroup()->wherePivot('status', '=', '1');
    }

    public function mentorInGroupWaiting()
    {
        return $this->mentorInGroup()->wherePivot('status', '=', '0');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'account_id', 'id');
    }
}
