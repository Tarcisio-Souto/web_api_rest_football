<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $age = rand(3, 100);
        $genre = rand(0, 1);
        $team_id = rand(1, 50);
        $position_id = rand(1, 30);

        return [
            'name' => $this->faker->name(),
            'age' => $age,
            'genre' => $genre,
            'teams_id' => $team_id,
            'positions_id' => $position_id
        ];
    }
}
