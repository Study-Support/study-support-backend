<?php

namespace App\Http\Resources;

use App\Models\UserInfo;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'account_name'  => $this->account->full_name,
            'group'         => $this->group->topic
        ];
    }
}
