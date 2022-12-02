<?php

namespace App\Services\JoinGroup;

interface JoinGroupServiceInterface
{
  /**
   * Form action join group as member
   *
   * @param $data
   * @param $answers
   * @return \Illuminate\Http\Response
   */
  public function joinGroupAsMember($data, $answers);

  /**
   * Form action join group as mentor
   *
   * @param $data
   * @param $answers
   * @return \Illuminate\Http\Response
   */
  public function joinGroupAsMentor($data, $answers);

}
