<?php

namespace Database\Factories;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "address" => "selakau",
            "gender" => fake()->randomElement(Gender::values()),
            "avatar" => null,
            "birth_date" => fake()->date,
            "birth_place" => fake()->streetAddress,
        ];
    }
}
