<?php

namespace Modules\Catalog\Database\Seeders;

use App\Enums\GoodsTypeEnum;
use Illuminate\Database\Seeder;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Specification;

class CatalogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rootCategory = Category::factory()->create(['type' => GoodsTypeEnum::PRODUCT->value]);
        $childCategories = Category::factory()->count(2)->create(['type' => GoodsTypeEnum::PRODUCT->value]);

        foreach ($childCategories as $childCategory) {
            $rootCategory->appendNode($childCategory);
            $childCategory->specifications()->saveMany(
                Specification::factory()->count(3)->withDependencies()->create(['leaf_category_id' => $childCategory->id])
            );
        }
    }
}
