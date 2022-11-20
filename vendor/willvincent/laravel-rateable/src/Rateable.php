<?php

namespace willvincent\Rateable;

use Illuminate\Support\Facades\Auth;

trait Rateable
{
    /**
     * This model has many ratings.
     *
     * @param mixed $rating
     * @param mixed $value
     * @param string $comment
     *
     * @return Rating
     */
    public function rate($value, $comment = null, $group_id)
    {
        $rating = new Rating();
        $rating->rating = $value;
        $rating->comment = $comment;
        $rating->group_id = $group_id;
        $rating->account_id = Auth::id();

        $this->ratings()->save($rating);
    }

    public function rateOnce($value, $comment = null, $group_id)
    {
        $rating = Rating::query()
            ->where('rateable_type', '=', $this->getMorphClass())
            ->where('rateable_id', '=', $this->id)
            ->where('account_id', '=', Auth::id())
            ->where('group_id', '=',  $group_id)
            ->first()
        ;

        if ($rating) {
            $rating->rating = $value;
            $rating->comment = $comment;
            $rating->save();
        } else {
            $this->rate($value, $comment, $group_id);
        }
    }

    public function ratings()
    {
        return $this->morphMany('willvincent\Rateable\Rating', 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

    public function timesRated()
    {
        return $this->ratings()->count();
    }

    public function usersRated()
    {
        return $this->ratings()->groupBy('account_id')->pluck('account_id')->count();
    }

    public function userAverageRating()
    {
        return $this->ratings()->where('account_id', Auth::id())->avg('rating');
    }

    public function userSumRating()
    {
        return $this->ratings()->where('account_id', Auth::id())->sum('rating');
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();

        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    // Getters

    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getUserAverageRatingAttribute()
    {
        return $this->userAverageRating();
    }

    public function getUserSumRatingAttribute()
    {
        return $this->userSumRating();
    }
}
