<?php

namespace Database\Factories;

use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Election::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "candidate" => $this->faker->name,
            "image" => null,
            "title" => $this->faker->name,
            "date" => $this->faker->date,
            "election_type_id" => 1,
            "description" => $this->faker->text
        ];
    }
}
