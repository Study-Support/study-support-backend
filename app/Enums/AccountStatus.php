<?php declare(strict_types=1);

namespace App\Enums;

use Illuminate\Validation\Rules\Enum as RulesEnum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AccountStatus extends RulesEnum
{
    const BLOCK = 0;
    const ACTIVE = 1;

    /**
   * Get all constants
   */
  public static function all()
  {
    return [
      self::BLOCK,
      self::ACTIVE,
    ];
  }
}
