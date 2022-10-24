<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
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
        'name' => 'Admin',
      ],
      [
        'id' => 2,
        'name' => 'Mod',
      ],
      [
        'id' => 3,
        'name' => 'User',
      ],
      [
        'id' => 4,
        'name' => 'Mentor',
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
      Role::updateOrCreate($row);
    }
  }
}
