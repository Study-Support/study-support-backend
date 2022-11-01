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
    $data = [
      'email' =>  'admin@test.com',
      'password' => 'Admin123',
      'role_id' => UserRole::USER,
      'remember_token' => Str::random(10)
    ];
    $isExist = Account::where('email', $data['email'])->exists();
    if (!$isExist) {
      Account::create($data);
    }
  }
}
