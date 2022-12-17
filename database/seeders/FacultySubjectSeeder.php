<?php

namespace Database\Seeders;

use App\Models\FacultySubject;
use Illuminate\Database\Seeder;

class FacultySubjectSeeder extends Seeder
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
                'faculty_id' => 1,
                'subject_id' => 2,
            ],
            [
                'faculty_id' => 1,
                'subject_id' => 1,
            ],
            [
                'faculty_id' => 1,
                'subject_id' => 3,
            ],
            [
                'faculty_id' => 1,
                'subject_id' => 4,
            ],
            [
                'faculty_id' => 1,
                'subject_id' => 5,
            ],
            [
                'faculty_id' => 1,
                'subject_id' => 6,
            ],
            [
                'faculty_id' => 2,
                'subject_id' => 3,
            ],
            [
                'faculty_id' => 2,
                'subject_id' => 4,
            ],
            [
                'faculty_id' => 3,
                'subject_id' => 5,
            ],
            [
                'faculty_id' => 3,
                'subject_id' => 4,
            ],
            [
                'faculty_id' => 4,
                'subject_id' => 2,
            ],
            [
                'faculty_id' => 5,
                'subject_id' => 2,
            ],
            [
                'faculty_id' => 5,
                'subject_id' => 3,
            ],
        ];

        $this->create($params);
    }

    /**
    * Insert table faculty_subject
    * @param array $data
    */
    public function create($data)
    {
        foreach ($data as $row) {
            FacultySubject::updateOrCreate($row);
        }
    }
}
