<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * @return array
     */
    public function definition()
    {
        return [
            'isbn' => $this->faker->isbn13,
            'book_name' => $this->faker->sentence,
            'published_at' => $this->faker->date('Y-m-d\TH:i:s.u', 'now'),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
        ];
    }
}
