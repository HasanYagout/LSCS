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
    {$majors = Major::pluck('id')->all();
        static $recordCount = 0;
        $registrationYear = $this->faker->numberBetween(20, 24);
        $specificIds = [
            '62120085',
            '62030104',
            '62110453',
        ];

        $id = isset($specificIds[$recordCount]) ? $specificIds[$recordCount] : '6' . $registrationYear . $this->faker->unique()->numberBetween(10000, 99999);
        $recordCount++;

        $firstName = $this->faker->firstName;
        $middleName = $this->faker->lastName;
        $lastName = $this->faker->lastName;
        $creditsLeft = $this->faker->numberBetween(0, 100);
        $email = strtolower($firstName . '.' . $lastName . '@gmail.com');

        if ($id === '62030104') {
            $firstName = 'Hasan';
            $middleName = 'Mohammed';
            $lastName = 'Yagout';
            $creditsLeft = 0;
            $email = 'yagouthasan3@gmail.com';
        } elseif ($id === '62120085') {
            $firstName = 'Yosif';
            $middleName = 'Mansour';
            $lastName = 'Yagout';
            $creditsLeft = 0;
            $email = strtolower($firstName . '.' . $lastName . '@gmail.com');
        } elseif ($id === '62110453') {
            $firstName = 'Yousif';
            $middleName = 'Mohammed';
            $lastName = 'Almansour';
            $creditsLeft = 0;
            $email = strtolower($firstName . '.' . $lastName . '@gmail.com');
        }

        return [
            'id' => $id,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'email' => $email,
            'gpa' => $this->faker->randomFloat(2, 1, 4),
            'major_id' => $this->faker->randomElement($majors),
            'registration_year' => '20' . $registrationYear,
            'credits_left' => $creditsLeft,
            'phone' => $this->faker->unique()->numberBetween(1, 1000),
        ];

    }
}
