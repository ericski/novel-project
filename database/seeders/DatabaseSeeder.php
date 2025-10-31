<?php

namespace Database\Seeders;

use App\Models\BannedWord;
use App\Models\DiscordInvite;
use App\Models\Event;
use App\Models\Flag;
use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\DiscordInviteFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $users = User::factory(30)->create();
//
//        $other_admins = User::factory(5)->create([
//            'is_admin' => true,
//        ]);

        $admin = User::factory()->create([
            'name' => 'Test Admin',
            'profile' => 'test-admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);

//        $basic_user = User::factory()->create([
//            'name' => 'Test Regular User',
//            'profile' => 'test-regular-user',
//            'bio' => fake()->paragraph(5),
//            'email' => 'user@example.com',
//            'email_verified_at' => now(),
//            'password' => bcrypt('password'),
//        ]);
//
//        DiscordInvite::factory(10)->recycle($users)->create();
//
//        Event::factory()->count(5)->recycle($other_admins)->create([
//            'is_active' => false,
//        ]);
//
//        Event::factory()->count(1)->recycle($other_admins)->create([
//            'name' => 'The Active Event',
//            'slug' => 'the-active-event',
//            'is_active' => true,
//            'start_date' => now()->subDays(5),
//            'end_date' => now()->addDays(25),
//        ]);
//
//        $all_events = Event::all();
//
//        Project::factory()->count(50)->recycle([$users,$all_events])->create();
//        Project::factory()->count(50)->recycle([$users])->create([
//            'event_id' => null,
//        ]);
//
//        Project::factory()->count(5)->recycle([$admin,$all_events])->create([
//            'active' => false,
//        ]);
//        Project::factory()->count(1)->recycle([$admin])->create([
//            'event_id' => null,
//            'active' => true,
//        ]);
//
//        Flag::factory()->count(10)->recycle($users)->create();
//
//        $all_projects = Project::all();
//        // Add updates to the projects
//        foreach ($all_projects as $project) {
//            $goal = $project->goal;
//            for ($i = 0; $i < fake()->numberBetween(1,5); $i++) {
//                $count = fake()->numberBetween(1, $goal / 2);
//                $goal -= $count;
//                $project->updates()->create([
//                    'count' => $count,
//                    'date' => now()->subDays($i),
//                ]);
//            }
//        }
//
//        for ($i = 0; $i <= 5; $i++) {
//            $type = fake()->boolean();
//            $goal = $type ? fake()->numberBetween(30000, 100000) : fake()->numberBetween(14, 60);
//
//            $demo_project = Project::factory()->create([
//                'author_id' => $basic_user->id,
//                'active' => $i % 5 === 0,
//                'status' => $i % 5 === 0 ? 'in progress' : fake()->randomElement(['pending', 'complete', 'shelved', 'abandoned']),
//                'goal_type' => $type,
//                'goal' => $goal,
//            ]);
//            for ($j = 0; $j < 5; $j++) {
//                $count = fake()->numberBetween(1, $goal / 2);
//                $goal -= $count;
//                $demo_project->updates()->create([
//                    'count' => $count,
//                    'date' => now()->subDays($j),
//                ]);
//            }
//        }
//
//        $admin->following()->attach($users->random(2));
//        $admin->following()->attach($basic_user);
//
//        $basic_user->following()->attach($users->random(3));
//
//        BannedWord::factory(20)->recycle($other_admins)->create();


    }
}
