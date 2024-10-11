<?php

namespace Database\Factories;

use App\Models\BannedWord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BannedWordFactory extends Factory
{
    protected $model = BannedWord::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'word' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
