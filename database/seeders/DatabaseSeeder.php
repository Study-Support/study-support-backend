<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      FacultyTableSeeder::class,
      RoleTableSeeder::class,
      AccountTableSeeder::class,
      SubjectSeeder::class,
      GroupSeeder::class,
      MentorInfoSeeder::class,
      UserInfoSeeder::class,
      MemberSeeder::class,
      MentorSubjectSeeder::class,
      FacultySubjectSeeder::class,
      MentorQuestionTableSeeder::class
    ]);
  }
}
