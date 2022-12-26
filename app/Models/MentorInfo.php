<?php

namespace App\Models;

use App\Enums\AccountStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Builder;

class MentorInfo extends Model
{
    use HasFactory, Rateable;

    protected $table = 'mentor_information';

    public $fillable = [
        'account_id',
        'cv_link',
        'smart_banking',
        'active'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'mentor_subject', 'mentor_id', 'subject_id')
            ->withPivot('id', 'cv_link', 'active');
    }

    public function subjectsAccepted()
    {
        return $this->subjects()->wherePivot('active', 1);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->whereHas('account', function ($q) {
                $q->where('is_active', AccountStatus::ACTIVE);
            });
        });
    }
}
