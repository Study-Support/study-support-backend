<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 */
final class MentorStatus extends Enum
{
    const WAITING = 0;
    const ACCEPTED = 1;

    /**
   * Get all constants
   */
  public static function all()
  {
    return [
      self::WAITING,
      self::ACCEPTED,
    ];
  }
}
