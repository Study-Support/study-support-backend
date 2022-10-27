<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(MentorInfo::class, 'mentor_subject', 'mentor_id', 'subject_id')
        ->withPivot('cv_link', 'active');
    }
}
