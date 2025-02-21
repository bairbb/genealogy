<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    protected $model = Person::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthYear = fake()->year('now');
        if (fake()->boolean(50)) {
            $deathYear = $birthYear + fake()->numberBetween(1, 100);
        } else {
            $deathYear = null;
        }

        return [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'surname' => fake()->firstName(),
            'birth_year' => $birthYear,
            'death_year' => $deathYear,
        ];
    }
}
