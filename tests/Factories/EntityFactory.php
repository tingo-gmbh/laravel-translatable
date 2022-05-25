<?php

namespace Tingo\Translatable\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Tingo\Translatable\Tests\Models\Entity;

class EntityFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'category' => Arr::random(['foo', 'bar', 'laravel']),
            'description' => $this->faker->text,
        ];
    }
}