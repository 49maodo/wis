<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP' ],
            ['name' => 'Laravel'  ],
            ['name' => 'JavaScript'],
            ['name' => 'HTML', ],
            ['name' => 'CSS'],
            ['name' => 'React'],
            ['name' => 'Vue.js'],
            ['name' => 'Python'],
            ['name' => 'Django'],
            ['name' => 'Java'],
            ['name' => 'Spring'],
            ['name' => 'C#'],
            ['name' => '.NET'],
            ['name' => 'Ruby'],
            ['name' => 'Rails'],
            ['name' => 'DevOps'],
            ['name' => 'AWS'],
            ['name' => 'Docker'],
            ['name' => 'Kubernetes'],
            ['name' => 'SQL'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
