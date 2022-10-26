<?php

namespace App\Enums;

class GroupStudy
{
  const SELF_STUDY = 1;
  const CONTROL = 0;

  /**
   * Get all constants
   */
  public static function all()
  {
    return [
      self::SELF_STUDY,
      self::CONTROL,
    ];
  }
}
