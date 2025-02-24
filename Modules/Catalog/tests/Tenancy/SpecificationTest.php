<?php

namespace Modules\Catalog\Tests\Tenancy;

use Tests\TestCase;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Specification;
use Modules\Catalog\Enum\SpecificationTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpecificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_specification_index()
    {
        $category = Category::factory()->create();
        Specification::factory()->count(3)->create(['leaf_category_id' => $category->id]);

        $response = $this->getJson('/api/v1/catalog/specifications');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'type', 'filter', 'position']
                ]
            ]);
    }

    public function test_specification_store()
    {
        $category = Category::factory()->create();

        $data = [
            "name" => [
                "uz" => "Test nomi",
                "ru" => "Тестовое имя",
                "en" => "Test name",
            ],
            "type" => SpecificationTypeEnum::DROPDOWN,
            "filter" => true,
            "position" => 1,
            "leaf_category_id" => $category->id,
        ];

        $response = $this->postJson('/api/v1/catalog/specifications', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(["name" => $data["name"][app()->getLocale()]]);

        $this->assertDatabaseHas('specifications', [
            "name->uz" => "Test nomi",
            "name->ru" => "Тестовое имя",
            "name->en" => "Test name",
            "type" => SpecificationTypeEnum::DROPDOWN,
            "filter" => true,
            "position" => 1,
            "leaf_category_id" => $category->id,
        ]);
    }

    public function test_specification_update()
    {
        $category = Category::factory()->create();
        $specification = Specification::factory()->create(['leaf_category_id' => $category->id]);

        $updateData = [
            "name" => [
                "uz" => "Yangi nom",
                "ru" => "Новое имя",
                "en" => "New name",
            ],
        ];

        $response = $this->putJson("/api/v1/catalog/specifications/{$specification->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(["name" => $updateData["name"][app()->getLocale()]]);

        $this->assertDatabaseHas('specifications', [
            "id" => $specification->id,
            "name->uz" => "Yangi nom",
            "name->ru" => "Новое имя",
            "name->en" => "New name",
        ]);
    }

    public function test_specification_delete()
    {
        $category = Category::factory()->create();
        $specification = Specification::factory()->create(['leaf_category_id' => $category->id]);

        $response = $this->deleteJson("/api/v1/catalog/specifications/{$specification->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('specifications', [
            "id" => $specification->id
        ]);
    }
}