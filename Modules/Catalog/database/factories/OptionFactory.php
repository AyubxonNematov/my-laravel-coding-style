<?php

namespace Modules\Catalog\Database\Factories;

use Illuminate\Support\Str;
use Modules\Catalog\Models\Option;
use Modules\Catalog\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Option::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'value' => [
                'en' => $this->faker->word(),
                'ru' => $this->faker->word(),
                'uz' => $this->faker->word(),
            ],
            'filter' => $this->faker->boolean(),
            'specification_id' => null,
        ];
    }
}

