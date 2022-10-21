<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $fillable = [
        'topic',
        'information',
        'time_study',
        'subject_id',
        'location_study',
        'is_active'
    ];
}
