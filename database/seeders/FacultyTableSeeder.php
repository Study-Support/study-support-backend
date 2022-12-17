<?php

namespace Database\Seeders;

use App\Models\Faculty;
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
                'name' => 'Công nghệ thông tin',
            ],
            [
                'name' => 'Cơ khí giao thông',
            ],
            [
                'name' => 'Quản lý dự án',
            ],
            [
                'name' => 'Điện tử viễn thông',
            ],
            [
                'name' => 'Môi trường',
            ]
        ];
        $this->create($params);
    }

    /**
    * Insert table faculties
    * @param array $data
    */
    public function create($data)
    {
        foreach ($data as $row) {
            Faculty::updateOrCreate($row);
        }
    }
}
