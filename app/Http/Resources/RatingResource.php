<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'rating'        => $this->rating,
            'comment'       => $this->comment,
            'account_id'    => $this->account_id,
            'account_from'  => $this->account->full_name,
            'group'         => $this->group->topic,
            'account_to'    => $this->rateable->account->userInfo->full_name
        ];
    }
}
