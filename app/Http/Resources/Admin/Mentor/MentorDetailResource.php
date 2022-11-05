<?php

namespace App\Http\Resources\Admin\Mentor;

use Illuminate\Http\Resources\Json\JsonResource;

class MentorDetailResource extends JsonResource
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
      'id'            => $this->pivot->id,
      'subject_id'    => $this->pivot->subject_id,
      'subject'       => $this->name,
      'cv_link'       => $this->pivot->cv_link,
      'status'        => $this->pivot->active
    ];
  }
}
