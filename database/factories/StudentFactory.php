<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->unique()->randomNumber(6),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'gpa' => $this->faker->randomFloat(2, 1, 4),
            'major' => $this->faker->jobTitle,
            'registration_year' => $this->faker->year,
            'graduation_year' => $this->faker->year,
            'credits_left' => $this->faker->numberBetween(0, 100),
            'number' => $this->faker->unique()->numberBetween(1, 1000),
        ];
    }
}
