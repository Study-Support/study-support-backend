<?php

namespace App\Services\CreateGroup;

interface CreateGroupServiceInterface
{
  /**
   * Form action create group
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function createGroup($data);
}
