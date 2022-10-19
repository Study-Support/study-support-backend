<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email' =>  'admin@test.com',
            'role_id' => UserRole::USER,
            'password' => 'Admin123',
            'remember_token' => Str::random(10)
        ];
        $isExist = Account::where('email', $data['email'])->exists();
        if (!$isExist) {
            Account::create($data);
        }
    }
}
