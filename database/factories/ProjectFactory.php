<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(4, true),
            'description' => htmlspecialchars(fake()->randomHtml()),
            'ends_at' => fake()->dateTimeBetween('now', '+3 days'),
            'status' => fake()->randomElement(['open', 'closed']),
            'tech_stack' => fake()->randomElements(['PHP', 'JavaScript', 'Python', 'Ruby', 'Go', 'Java', 'C#'], random_int(1, 3)),
            'created_by' => User::factory(),
        ];
    }
}
