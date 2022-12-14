<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorQuestion extends Model
{
    use HasFactory;

    public $fillable = [ 'content' ];
}
