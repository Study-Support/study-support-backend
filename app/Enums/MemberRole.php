<?php

namespace App\Enums;

class MemberRole
{
  const MENTOR = 1;
  const MEMBER = 0;

  /**
   * Get all constants
   */
  public static function all()
  {
    return [
      self::MENTOR,
      self::MEMBER,
    ];
  }
}
