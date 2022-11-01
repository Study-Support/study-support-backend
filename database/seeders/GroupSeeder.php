<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
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
        'topic' => 'Ôn tập thi giữa Kỳ',
        'information' => 'Nhóm mục đích giành cho các bạn mất gốc',
        'time_study' => 'Học thứ 2, 6 mỗi tuần từ 7h đến 9h',
        'subject_id' => '2',
        'location_study' => 'A123',
        'status' => '1',
        'faculty_id' => '1',
        'self_study' => '1'
      ],
      [
        'id' => 2,
        'topic' => 'Ôn tập thi Cuối Kỳ',
        'information' => 'Nhóm mục đích giành cho các bạn có mục tiêu 8 điểm',
        'time_study' => 'Học thứ 5, 6 mỗi tuần từ 8h đến 10h',
        'subject_id' => '3',
        'location_study' => 'B102',
        'status' => '1',
        'faculty_id' => '2',
        'self_study' => '0'
      ],
      [
        'id' => 3,
        'topic' => 'Ôn tập thi Cuối Kỳ',
        'information' => 'Nhóm mục đích giành cho các bạn muốn qua môn',
        'time_study' => 'Học thứ 7, CN mỗi tuần từ 14h đến 16h',
        'subject_id' => '2',
        'location_study' => 'C112',
        'status' => '0',
        'faculty_id' => '3',
        'self_study' => '0'
      ]
    ];
    $this->create($params);
  }

  /**
   * Insert table groups
   * @param array $data
   */
  public function create($data)
  {
    foreach ($data as $row) {
      Group::updateOrCreate($row);
    }
  }
}
