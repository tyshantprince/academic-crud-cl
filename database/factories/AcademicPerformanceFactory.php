<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicPerformance>
 */
class AcademicPerformanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'student_group' => fake()->randomElement(['A', 'B']),
            'subject' => fake()->randomElement(['Math', 'Science', 'History']),
            'date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'assessment_score' => fake()->numberBetween(0,100),
        ];
    }
}
