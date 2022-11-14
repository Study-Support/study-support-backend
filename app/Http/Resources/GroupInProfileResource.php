<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupInProfileResource extends JsonResource
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
      'id'          => $this->id,
      'subject'     => $this->subject->name,
      'is_creator'  => $this->pivot->is_creator,
      'is_mentor'   => $this->pivot->is_mentor
    ];
  }
}
