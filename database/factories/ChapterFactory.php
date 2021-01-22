<?php

namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company . " " . $this->faker->companySuffix,
            'email' => $this->faker->companyEmail,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'type' => $this->faker->word(6),
            'company_id' => $this->faker->numberBetween(1, 60),
            'country_id' => $this->faker->numberBetween(1, 239),
            'language_id' => $this->faker->numberBetween(1, 182),
        ];
    }
}
