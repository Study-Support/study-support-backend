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
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(UserInfo::class, 'account_id', 'account_id');
    }
}
