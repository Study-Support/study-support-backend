<?php

namespace App\Enums;

class UserGender
{
  const FEMALE = 0;
  const MALE = 1;

  /**
   * Get all constants
   */
  public static function all()
  {
    return [
      self::FEMALE,
      self::MALE,
    ];
  }
}
