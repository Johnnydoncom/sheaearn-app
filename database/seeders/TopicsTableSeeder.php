<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = [
            'Sport',
            'Africa',
            'World',
            'Video',
            'Entertainment',
            'Politics'
        ];

        foreach ($topics as $topic) {
            Topic::create(['name'=>$topic]);
        }
    }
}
