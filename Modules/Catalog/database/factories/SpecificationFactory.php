<?php

namespace Modules\Catalog\Database\Factories;

use Illuminate\Support\Str;
use Modules\Catalog\Models\Option;
use Modules\Catalog\Models\Specification;
use Modules\Catalog\Enum\SpecificationTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Specification::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => [
                'en' => $this->faker->word(),
                'ru' => $this->faker->word(),
                'uz' => $this->faker->word(),
            ],
            'type' => $this->faker->randomElement(SpecificationTypeEnum::values()),
            'filter' => $this->faker->boolean(),
            'position' => $this->faker->numberBetween(1, 100),
            'leaf_category_id' => null,
        ];
    }

    public function withDependencies(): Factory
    {
        return $this->afterCreating(function (Specification $specification)  {
            $specification->options()->saveMany(Option::factory()->count(3)->create(['specification_id' => $specification->id]));
        });
    }
}

