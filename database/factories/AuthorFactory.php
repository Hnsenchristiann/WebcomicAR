<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'social_media_links' => '[]',
            'description' => $this->faker->paragraph(),
            'profile_picture_url' => '/storage/media/authors/alan_moore.jpg'
        ];
    }
}
