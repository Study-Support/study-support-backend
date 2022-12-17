<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultySubject extends Model
{
    use HasFactory;

    protected $table = 'faculty_subject';

    public $fillable = [
        'faculty_id',
        'subject_id'
    ];
}
