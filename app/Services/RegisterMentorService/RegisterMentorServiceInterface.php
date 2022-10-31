<?php

namespace App\Services\RegisterMentorService;

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
