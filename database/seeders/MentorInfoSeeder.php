<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\MentorInfo;
use Illuminate\Database\Seeder;

class MentorInfoSeeder extends Seeder
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
                'id' => 1,
                'account_id' => Account::where('email', 'thaott@test.com')->first()->id,
                'smart_banking' => 'Vietcombank',
            ],
            [
                'id' => 2,
                'account_id' => Account::where('email', 'tiennv@test.com')->first()->id,
                'smart_banking' => 'Viettinbank',
            ],
            [
                'id' => 3,
                'account_id' => Account::where('email', 'quangdt@test.com')->first()->id,
                'smart_banking' => 'MBBank',
            ]
        ];
        $this->create($params);
    }

    /**
   * Insert table MentorInfo
   * @param array $data
   */
  public function create($data)
  {
    foreach ($data as $row) {
      MentorInfo::updateOrCreate($row);
    }
  }
}
