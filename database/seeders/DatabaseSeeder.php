<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(200)->create();

        User::query()
            ->inRandomOrder()->limit(20)->get()
            ->each(function (User $user): void {
                $project = Project::factory()->create([
                    'created_by' => $user->id,
                ]);

                Proposal::factory(random_int(1, 15))->create([
                    'project_id' => $project->id,
                ]);
            });
    }
}
