<?php

namespace Modules\Catalog\Database\Factories;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Enums\GoodsTypeEnum;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Category::class;

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
            'slug' => $this->faker->slug(),
            'icon' => [ "id" => 1, "path" =>  $this->faker->imageUrl(100, 100, 'icons')],
            'photo' => [ "id" => 1, "path" =>  $this->faker->imageUrl(100, 100, 'photo')],
            'photo_focus' => [ "id" => 1, "path" =>  $this->faker->imageUrl(100, 100, 'photo_focus')],
            'coefficient' => $this->faker->randomDigitNotNull(),
            'coefficient_commissioner' => $this->faker->randomDigitNotNull(),
            'coefficient_extra' => $this->faker->randomDigitNotNull(),
            'status' => StatusEnum::DRAFT->value, 
            'type' => $this->faker->randomElement(GoodsTypeEnum::values()),
            'position' => $this->faker->numberBetween(1, 100),
            'parent_id' => null, 
        ];
    }

    public function withDependencies(): Factory
    {
        return $this->afterCreating(function (Category $category) {
            $category->specifications()
            ->saveMany(Specification::factory()
            ->count(3)
            ->withDependencies()
            ->create(['leaf_category_id' => $category->id]));
        });
    }
}

