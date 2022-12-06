<?php

namespace willvincent\Rateable;

use App\Models\Group;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    public $fillable = ['rating', 'comment'];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        $userClassName = Config::get('auth.model');
        if (is_null($userClassName)) {
            $userClassName = Config::get('auth.providers.users.model');
        }

        return $this->belongsTo($userClassName);
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function account()
    {
        return $this->hasOne(UserInfo::class, 'account_id', 'account_id');
    }
}
