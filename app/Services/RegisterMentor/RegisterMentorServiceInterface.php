<?php

namespace App\Services\RegisterMentor;

interface RegisterMentorServiceInterface
{
  /**
   * Form action register mentor
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function registerMentor($data);

}
