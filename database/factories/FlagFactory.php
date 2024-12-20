<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flag>
 */
class FlagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = $this->faker->randomElement(['App\Models\Project', 'App\Models\User']);
        $defaults = [];
        if ($model === 'App\Models\Project') {
            $defaults = [
                'event_id' => null
            ];
        }
        $model = $model::factory()->create($defaults);
        return [
            'user_id' => User::factory(),
            'flaggable_type' => $model::class,
            'flaggable_id' => $model->id,
        ];
    }
}
