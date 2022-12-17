<?php

namespace Database\Seeders;

use App\Models\Mentor_Subject;
use App\Models\MentorInfo;
use Illuminate\Database\Seeder;

class MentorSubjectSeeder extends Seeder
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
                'mentor_id' => MentorInfo::where('id', '1')->first()->id,
                'subject_id' => '3',
                'cv_link'   => 'https://thao7420.backlog.com/dashboard',
                'active'    => 1
            ],
            [
                'id' => 2,
                'mentor_id' => MentorInfo::where('id', '1')->first()->id,
                'subject_id' => '2',
                'cv_link'   => 'https://thao7420.backlog.com/dashboard',
                'active'    => 0
            ],
            [
                'id' => 3,
                'mentor_id' => MentorInfo::where('id', '2')->first()->id,
                'subject_id' => '4',
                'cv_link'   => 'https://thao7420.backlog.com/dashboard',
                'active'    => 1
            ],
            [
                'id' => 4,
                'mentor_id' => MentorInfo::where('id', '3')->first()->id,
                'subject_id' => '3',
                'cv_link'   => 'https://thao7420.backlog.com/dashboard',
                'active'    => 1
            ],
            [
                'id' => 5,
                'mentor_id' => MentorInfo::where('id', '3')->first()->id,
                'subject_id' => '6',
                'cv_link'   => 'https://thao7420.backlog.com/dashboard',
                'active'    => 0
            ],
            [
                'id' => 6,
                'mentor_id' => MentorInfo::where('id', '3')->first()->id,
                'subject_id' => '5',
                'cv_link'   => 'https://thao7420.backlog.com/dashboard',
                'active'    => 1
            ],

        ];
        $this->create($params);
    }

    /**
     * Insert table MentorSubject
     * @param array $data
     */
    public function create($data)
    {
        foreach ($data as $row) {
            Mentor_Subject::updateOrCreate($row);
        }
    }
}
