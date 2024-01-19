<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    /**
     * @return array
     */
    public function definition()
    {
        return [
            'publisher_name' => $this->faker->name,
        ];
    }
}
