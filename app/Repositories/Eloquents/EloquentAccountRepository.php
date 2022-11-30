<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\AccountRepository;
use \App\Models\Account;

/**
 * Class EloquentAccountRepository
 * @package App\Repositories\Eloquents
 */
class EloquentAccountRepository extends EloquentBaseRepository implements AccountRepository
{
    public function getModel()
    {
        return Account::class;
    }

    
}
