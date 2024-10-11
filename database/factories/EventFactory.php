<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $start = Carbon::now()->subDays(rand(10, 150));
        $end = $start->copy()->addDays(rand(7, 30));
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->words(4, true),
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'is_active' => $this->faker->boolean,
            'start_date' => $start,
            'end_date' => $end,
            'creator' => User::factory(),
        ];
    }
}
