<?php

namespace App\Services\JoinGroup;

interface JoinGroupServiceInterface
{
  /**
   * Form action join group as member
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function joinGroupAsMember($data);

  /**
   * Form action join group as mentor
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function joinGroupAsMentor($data);

}
