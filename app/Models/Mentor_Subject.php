<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor_Subject extends Model
{
  use HasFactory;

  protected $table = 'mentor_subject';

  protected $fillable = [
    'mentor_id',
    'subject_id',
    'cv_link',
    'active'
  ];
}
