<?php

namespace Database\Seeders;

use App\Models\MentorQuestion;
use Illuminate\Database\Seeder;

class MentorQuestionTableSeeder extends Seeder
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
                'content'   => 'Bạn có chắc chắn sẽ theo sát các thành viên trong nhóm không?'
            ],
            [
                'content'   => 'Bạn sẽ lên chương trình để hướng dẫn những bạn trong nhóm ôn tập như thế nào?'
            ],
            [
                'content'   => 'Bạn sẽ sắp xếp được thời gian để theo các bạn trong nhóm đến cùng chứ?'
            ],
        ];

        $this->create($params);
    }

    /**
     * Insert table Mentor Question
     * @param array $data
     */
    public function create($data)
    {
        foreach ($data as $row) {
            MentorQuestion::updateOrCreate($row);
        }
    }
}
