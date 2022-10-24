<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
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
        'name' => 'Lập trình hướng đối tượng',
      ],
      [
        'id' => 2,
        'name' => 'Vật lý 1',
      ],
      [
        'id' => 3,
        'name' => 'Đại số tuyến tính',
      ]
    ];
    $this->create($params);
  }

  /**
   * Insert table subjects
   * @param array $data
   */
  public function create($data)
  {
    foreach ($data as $row) {
      Subject::updateOrCreate($row);
    }
  }
}
