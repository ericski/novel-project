<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjectUpdateFactory extends Factory
{
    protected $model = ProjectUpdate::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'count' => $this->faker->randomNumber(),
            'date' => Carbon::now(),

            'project_id' => Project::factory(),
        ];
    }
}
