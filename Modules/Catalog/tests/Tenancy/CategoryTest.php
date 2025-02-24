<?php

namespace Modules\Catalog\Tests\Tenancy;

use Tests\TestCase;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Enums\GoodsTypeEnum;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Specification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private Category $rootCategory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedCategories();
    }

    private function seedCategories(): void
    {
        $this->rootCategory = $this->createCategoryWithType(GoodsTypeEnum::PRODUCT);
        
        $childCategories = Category::factory()
            ->count(2)
            ->create(['type' => GoodsTypeEnum::PRODUCT->value]);
    
        $childCategories->each(fn ($child) => $this->attachChildCategoryWithSpecifications($child));
    }
    
    private function createCategoryWithType($type): Category
    {
        return Category::factory()->create(['type' => $type->value]);
    }
    
    private function attachChildCategoryWithSpecifications(Category $childCategory): void
    {
        $this->rootCategory->appendNode($childCategory);
        
        $childCategory->specifications()->saveMany(
            Specification::factory()
                ->count(3)
                ->withDependencies()
                ->create(['leaf_category_id' => $childCategory->id])
        );
    }

    public function test_category_index(): void
    {
        $response = $this->getJson('/api/v1/catalog/categories');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 
                        'name', 
                        'slug', 
                        'icon', 
                        'photo', 
                        'photo_focus', 
                        'coefficient', 
                        'coefficient_commissioner',
                        'coefficient_extra', 
                        'type', 
                        'position'
                    ],
                ],
            ]);
    }

    public function test_category_show(): void
    {
        $response = $this->json('GET', "/api/v1/catalog/categories/{$this->rootCategory->id}", ['with' => 'children']);

        $response->assertOk()
            ->assertJsonStructure([
                'id', 
                'name', 
                'slug', 
                'icon', 
                'photo', 
                'photo_focus', 
                'coefficient', 
                'coefficient_commissioner',
                'coefficient_extra', 
                'status', 
                'type', 
                'position',
                'children' => [
                    '*' => [
                        'id', 
                        'name', 
                        'slug', 
                        'icon', 
                        'photo', 
                        'photo_focus', 
                        'coefficient', 
                        'status', 
                        'type', 
                        'position'
                    ],
                ],
                'parent_id',
            ]);
    }

    public function test_category_store(): void
    {
        $data = [
            'name' => ['uz' => 'Kategoriya', 'ru' => 'Категория', 'en' => 'Category'],
            'parent_id' => null,
            'icon' => [
                'id' => 1,
                'original' => fake()->imageUrl(),
                'large' => fake()->imageUrl(),
                'medium' => fake()->imageUrl(),
                'small' => fake()->imageUrl(),
            ],
            'photo' => [
                [
                    'id' => 1,
                    'original' => fake()->imageUrl(),
                    'large' => fake()->imageUrl(),
                    'medium' => fake()->imageUrl(),
                    'small' => fake()->imageUrl(),
                ],
            ],
            'photo_focus' => [
                'id' => 1,
                'original' => fake()->imageUrl(),
                'large' => fake()->imageUrl(),
                'medium' => fake()->imageUrl(),
                'small' => fake()->imageUrl(),
            ],
            'type' => GoodsTypeEnum::PRODUCT->value,
            'status' => StatusEnum::ACTIVE->value,
            'coefficient' => 1.2,
            'coefficient_commissioner' => 1.1,
            'coefficient_extra' => 1.2,
            'position' => 1,
        ];

        $response = $this->postJson('/api/v1/catalog/categories', $data);
        
        $locale = app()->getLocale(); // Joriy tilni olamiz

        $response->assertCreated();
        
        $response->assertJson([
            'name' => $data['name'][$locale], // Faqat joriy til
            'slug' => Str::slug($data['name'][$locale]),
            'icon' => [
                'id' => 1,
                'original' => $data['icon']['original'],
                'large' => $data['icon']['large'],
                'medium' => $data['icon']['medium'],
                'small' => $data['icon']['small'],
            ],
            'photo' => [
                [
                    'id' => 1,
                    'original' => $data['photo'][0]['original'],
                    'large' => $data['photo'][0]['large'],
                    'medium' => $data['photo'][0]['medium'],
                    'small' => $data['photo'][0]['small'],
                ],
            ],
            'photo_focus' => [
                'id' => 1,
                'original' => $data['photo_focus']['original'],
                'large' => $data['photo_focus']['large'],
                'medium' => $data['photo_focus']['medium'],
                'small' => $data['photo_focus']['small'],
            ],
            'coefficient' => $data['coefficient'],
            'coefficient_commissioner' => $data['coefficient_commissioner'],
            'coefficient_extra' => $data['coefficient_extra'],
            'type' => $data['type'],
            'position' => $data['position'],
        ]);
    }

    public function test_category_update(): void
    {
        $category =  Category::factory()->create();

        $data = [
                'name' => ['uz' => 'Kategoriya', 'ru' => 'Категория', 'en' => 'Category'],
                'parent_id' => null,
                'icon' => [
                    'id' => 1,
                    'original' => fake()->imageUrl(),
                'large' => fake()->imageUrl(),
                'medium' => fake()->imageUrl(),
                'small' => fake()->imageUrl(),
            ],
            'photo' => [
                [
                    'id' => 1,
                    'original' => fake()->imageUrl(),
                    'large' => fake()->imageUrl(),
                    'medium' => fake()->imageUrl(),
                    'small' => fake()->imageUrl(),
                ],
            ],
            'photo_focus' => [
                'id' => 1,
                'original' => fake()->imageUrl(),
                'large' => fake()->imageUrl(),
                'medium' => fake()->imageUrl(),
                'small' => fake()->imageUrl(),
            ],
            'type' => GoodsTypeEnum::PRODUCT->value,
            'status' => StatusEnum::ACTIVE->value,
            'coefficient' => 1.2,
            'coefficient_commissioner' => 1.1,
            'coefficient_extra' => 1.2,
            'position' => 1,
        ];

        $response = $this->putJson("/api/v1/catalog/categories/{$category->id}", $data);

        $locale = app()->getLocale();

        $response->assertOk()
            ->assertJson([
                'name' => $data['name'][$locale],
                'slug' => Str::slug($data['name'][$locale]),
                'icon' => [
                    'id' => 1,
                    'original' => $data['icon']['original'],
                    'large' => $data['icon']['large'],
                    'medium' => $data['icon']['medium'],
                    'small' => $data['icon']['small'],
                ],
                'photo' => [
                    [
                        'id' => 1,
                        'original' => $data['photo'][0]['original'],
                        'large' => $data['photo'][0]['large'],
                        'medium' => $data['photo'][0]['medium'],
                        'small' => $data['photo'][0]['small'],
                    ],
                ],
                'photo_focus' => [
                    'id' => 1,
                    'original' => $data['photo_focus']['original'],
                    'large' => $data['photo_focus']['large'],
                    'medium' => $data['photo_focus']['medium'],
                    'small' => $data['photo_focus']['small'],
                ],
                'coefficient' => $data['coefficient'],
                'coefficient_commissioner' => $data['coefficient_commissioner'],
                'coefficient_extra' => $data['coefficient_extra'],
                'type' => $data['type'],
                'position' => $data['position'],
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'type' => $data['type'],
            'status' => $data['status'],
            'coefficient' => $data['coefficient'],
            'coefficient_commissioner' => $data['coefficient_commissioner'],
            'coefficient_extra' => $data['coefficient_extra'],
            'position' => $data['position'],
        ]);
    }
    
    public function test_category_get_tree(): void
    {
        $response = $this->getJson('/api/v1/catalog/categories-tree');
        
        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id', 
                    'name', 
                    'slug',
                    'icon', 
                    'children' => [
                        '*' => [
                            'id', 
                            'name', 
                            'slug', 
                            'icon'
                        ]
                    ]
                ]
            ]);
    }
    
    public function test_category_get_breadcrumbs(): void
    {
        $category = Category::factory()->create();
        
        $response = $this->getJson("/api/v1/catalog/categories-breadcrumbs/{$category->id}");
        
        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id', 
                    'name', 
                    'slug', 
                    'icon'
                ]
            ]);
    }

    public function test_category_search(): void
    {
        Category::factory()->create([
            'name' => [
                'uz' => 'Test Kategoriya'
            ]
        ]);
        
        $response = $this->getJson('/api/v1/catalog/categories-search/Test');

        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id', 
                    'name', 
                    'slug', 
                    'icon'
                ]
            ]);
    }
}
