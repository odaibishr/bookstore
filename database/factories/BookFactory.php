<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'category_id' => $this->faker->numberBetween(1, Category::count()),
            'publisher_id' => $this->faker->numberBetween(1, Publisher::count()),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'number_of_pages' => $this->faker->numberBetween(100, 250),
            'number_of_copies' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'isbn' => $this->faker->isbn13(),
            'cover_image' => 'images/covers/' . $this->faker->randomElement(['1.png', '2.png', '3.png', '4.png', '5.png', '6.png']),
            'publish_year' => $this->faker->year(),
        ];
    }
}
