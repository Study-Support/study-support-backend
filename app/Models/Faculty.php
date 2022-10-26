<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'faculty_subject', 'subject_id', 'faculty_id');
    }

    public function users()
    {
        return $this->hasMany(UserInfo::class, 'faculty_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'faculty_id');
    }
}
