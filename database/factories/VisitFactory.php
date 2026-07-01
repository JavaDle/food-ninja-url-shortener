<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'link_id' => Link::factory(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'referer' => fake()->optional()->url(),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'visited_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
