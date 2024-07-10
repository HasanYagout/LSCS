<?php

namespace Database\Factories;

use App\Models\Major;
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
        $majors = Major::pluck('id')->all();

        return [
            'id' => $this->faker->unique()->randomNumber(8),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'gpa' => $this->faker->randomFloat(2, 1, 4),
            'major_id' => $this->faker->randomElement($majors),
            'registration_year' => $this->faker->year,
            'credits_left' => $this->faker->numberBetween(0, 100),
            'number' => $this->faker->unique()->numberBetween(1, 1000),
        ];
    }
}
