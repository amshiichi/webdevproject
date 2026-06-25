<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;

class JobListingSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'employer_id' => 2,
                'title' => 'Gameplay Programmer',
                'company' => 'Dragonforge Interactive',
                'location' => 'Quezon City',
                'description' => 'Develop combat systems, AI behavior trees, and gameplay mechanics for an open-world fantasy RPG.',
                'requirements' => 'Godot, Unity, or Unreal experience.',
                'type' => 'full-time',
                'experience_level' => 'entry',
                'salary_min' => 25000,
                'salary_max' => 40000,
                'status' => 'approved',
                'posting_status' => 'live'
            ],
            [
                'employer_id' => 2,
                'title' => '3D Environment Artist',
                'company' => 'Moonveil Studios',
                'location' => 'Remote',
                'description' => 'Create castles, forests, dungeons, and magical environments for fantasy adventures.',
                'requirements' => 'Blender and Substance Painter.',
                'type' => 'full-time',
                'experience_level' => 'mid',
                'salary_min' => 40000,
                'salary_max' => 65000,
                'status' => 'approved',
                'posting_status' => 'live'
            ],
            [
                'employer_id' => 2,
                'title' => 'Technical Game Designer',
                'company' => 'Aetherbound Games',
                'location' => 'Pasig City',
                'description' => 'Design quests, progression systems, and balancing for cooperative RPG experiences.',
                'requirements' => 'Game design portfolio.',
                'type' => 'full-time',
                'experience_level' => 'mid',
                'salary_min' => 45000,
                'salary_max' => 70000,
                'status' => 'approved',
                'posting_status' => 'live'
            ],
            [
                'employer_id' => 2,
                'title' => 'VFX Artist',
                'company' => 'Runebreaker Entertainment',
                'location' => 'Makati City',
                'description' => 'Produce spell effects, explosions, particles, and cinematic visual effects.',
                'requirements' => 'Unity VFX Graph or Unreal Niagara.',
                'type' => 'contract',
                'experience_level' => 'senior',
                'salary_min' => 70000,
                'salary_max' => 100000,
                'status' => 'approved',
                'posting_status' => 'live'
            ],
            [
                'employer_id' => 2,
                'title' => 'Narrative Designer',
                'company' => 'Silver Griffin Works',
                'location' => 'Remote',
                'description' => 'Write branching storylines, world lore, and companion dialogue for fantasy RPG projects.',
                'requirements' => 'Strong creative writing portfolio.',
                'type' => 'part-time',
                'experience_level' => 'entry',
                'salary_min' => 18000,
                'salary_max' => 30000,
                'status' => 'approved',
                'posting_status' => 'live'
            ]
        ];

        foreach($jobs as $job){
            JobListing::create($job);
        }
    }
}