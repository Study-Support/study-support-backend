<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
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
                'account_id' => Account::where('email', 'thaott@test.com')->first()->id,
                'group_id'   => Group::where('id', '1')->first()->id,
                'is_creator' => '1',
                'is_mentor' => '0',
                'status'    => '1'
            ],
            [
                'account_id' => Account::where('email', 'thaott@test.com')->first()->id,
                'group_id'   => Group::where('id', '2')->first()->id,
                'is_creator' => '0',
                'is_mentor' => '1',
                'status'    => '1'
            ],
            [
                'account_id' => Account::where('email', 'thaott@test.com')->first()->id,
                'group_id'   => Group::where('id', '3')->first()->id,
                'is_creator' => '0',
                'is_mentor' => '0',
                'status'    => '0'
            ],
            [
                'account_id' => Account::where('email', 'tiennv@test.com')->first()->id,
                'group_id'   => Group::where('id', '1')->first()->id,
                'is_creator' => '0',
                'is_mentor' => '1',
                'status'    => '1'
            ],
            [
                'account_id' => Account::where('email', 'tiennv@test.com')->first()->id,
                'group_id'   => Group::where('id', '2')->first()->id,
                'is_creator' => '1',
                'is_mentor' => '0',
                'status'    => '1'
            ],
            [
                'account_id' => Account::where('email', 'quangdt@test.com')->first()->id,
                'group_id'   => Group::where('id', '3')->first()->id,
                'is_creator' => '0',
                'is_mentor' => '1',
                'status'    => '1'
            ],
            [
                'account_id' => Account::where('email', 'quangdt@test.com')->first()->id,
                'group_id'   => Group::where('subject_id', '2')->first()->id,
                'is_creator' => '0',
                'is_mentor' => '0',
                'status'    => '1'
            ],
            [
                'account_id' => Account::where('email', 'quangdt@test.com')->first()->id,
                'group_id'   => Group::where('subject_id', '1')->first()->id,
                'is_creator' => '0',
                'is_mentor' => '0',
                'status'    => '1'
            ],
        ];

        $this->create($params);
    }

    /**
     * Insert table Members
     * @param array $data
     */
    public function create($data)
    {
        foreach ($data as $row) {
            Member::updateOrCreate($row);
        }
    }
}
