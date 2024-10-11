<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'name' => $name,
            'profile' => Str::of($name)->slug('-'),
            'bio' => fake()->numberBetween(1, 100) <= 80 ? fake()->paragraph(5) : null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => fake()->boolean ? now() : null,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'avatar' => $this->create_avatar($name),
            'censored' => fake()->boolean(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Create a random avatar for the user.
     */
    private function create_avatar(string $name): string
    {
        if (fake()->boolean()) {
            $settings = [
                'size' => 300,
                'color' => '7F9CF5',
                'background' => 'EBF4FF',
                'name' => $name,
            ];
            return 'https://ui-avatars.com/api/?'.http_build_query($settings);
        }
        return 'https://i.pravatar.cc/150?u='.$name;
    }
}
