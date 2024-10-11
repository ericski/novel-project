<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $name = $this->faker->words(5, true);
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'title' => $name,
            'slug' => Str::of($name)->slug('-'),
            'goal' => $this->faker->randomNumber() + 1,
            'goal_type' => $this->faker->boolean(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'in progress', 'shelved', 'abandoned', 'complete']),
            'active' => $this->faker->boolean(),
            'cover' => 'https://picsum.photos/seed/'.uniqid().'/420/630',
            'censored' => fake()->boolean(10),
            'author_id' => User::factory(),
            'event_id' => Event::factory(),
        ];
    }
}
