<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultyTableSeeder extends Seeder
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
                'name' => 'CNTT',
            ],
            [
                'id' => 2,
                'name' => 'CKGT',
            ],
            [
                'id' => 3,
                'name' => 'QLDA',
            ]
        ];
        $this->create($params);
    }

    /**
    * Insert table roles
    * @param array $data
    */
    public function create($data)
    {
        foreach ($data as $row) {
            Faculty::updateOrCreate($row);
        }
    }
}
