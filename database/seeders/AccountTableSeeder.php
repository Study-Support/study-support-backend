<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Account;
use App\Models\Account_Role;
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
        $params = [
            [
                'email' =>  'admin@test.com',
                'password' => 'Admin123',
                'role_id' => UserRole::ADMIN,
                'remember_token' => Str::random(10)
            ],
            [
                'email' =>  'thaott@test.com',
                'password' => 'Admin123',
                'role_id' => UserRole::USER,
                'remember_token' => Str::random(10)
            ],
            [
                'email' =>  'tiennv@test.com',
                'password' => 'Admin123',
                'role_id' => UserRole::USER,
                'remember_token' => Str::random(10)
            ],
            [
                'email' =>  'quangdt@test.com',
                'password' => 'Admin123',
                'role_id' => UserRole::USER,
                'remember_token' => Str::random(10)
            ]
        ];

        $this->create($params);
    }

    /**
   * Insert table accounts
   * @param array $data
   */
  public function create($data)
  {
    foreach ($data as $row) {
        $isExist = Account::where('email', $row['email'])->exists();

        if (!$isExist) {
            Account::create($row);
        }
    }
  }
}
