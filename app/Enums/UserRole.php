<?php declare(strict_types=1);

namespace App\Enums;

use Illuminate\Validation\Rules\Enum as RulesEnum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRole extends RulesEnum
{
    const ADMIN = 1;
    const USER = 3;
}
