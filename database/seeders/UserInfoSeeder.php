<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder
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
                'full_name' => 'Trần Thị Thảo',
                'address'   => 'An Bằng, Vinh An, Huế',
                'phone_number'  => '0987764294',
                'birthday'  => '07/04/2000',
                'faculty_id'=> '1',
                'gender'    => '0',
            ],
            [
                'id' => 2,
                'account_id' => Account::where('email', 'tiennv@test.com')->first()->id,
                'full_name' => 'Nguyễn Văn Tiến',
                'address'   => 'Hòa Vang, Đà Nẵng',
                'phone_number'  => '0987764295',
                'birthday'  => '02/03/2001',
                'faculty_id'=> '2',
                'gender'    => '1',
            ],
            [
                'id' => 3,
                'account_id' => Account::where('email', 'quangdt@test.com')->first()->id,
                'full_name' => 'Đặng Tiến Quang',
                'address'   => 'Hải Châu, Đà Nẵng',
                'phone_number'  => '0986543212',
                'birthday'  => '02/02/2002',
                'faculty_id'=> '3',
                'gender'    => '1',
            ],
            [
                'id' => 4,
                'account_id' => Account::where('email', 'nhuht@test.com')->first()->id,
                'full_name' => 'Hoàng Thị Thu Như',
                'address'   => 'Hải Châu, Đà Nẵng',
                'phone_number'  => '0986543212',
                'birthday'  => '02/02/2002',
                'faculty_id'=> '3',
                'gender'    => '1',
            ]
        ];
        $this->create($params);
    }

    /**
   * Insert table UserInfo
   * @param array $data
   */
  public function create($data)
  {
    foreach ($data as $row) {
      UserInfo::updateOrCreate($row);
    }
  }
}
