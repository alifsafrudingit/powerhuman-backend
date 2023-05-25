<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'age'  => $this->faker->numberBetween(17, 55),
            'phone' => $this->faker->phoneNumber(),
            'photo' => $this->faker->imageUrl(),
            // 'is_verified' => $this->faker->boolean(),
            // 'verfied_at' => $this->faker->dateTime(),
            'team_id' => $this->faker->numberBetween(1, 8),
            'role_id' => $this->faker->numberBetween(1, 40)
        ];
    }
}
