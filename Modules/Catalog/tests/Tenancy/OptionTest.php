<?php

namespace Modules\Catalog\Tests\Tenancy;

use Tests\TestCase;
use Modules\Catalog\Models\Option;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Specification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_option_index()
    {
        $category = Category::factory()->create();
        $specification = Specification::factory()->create(['leaf_category_id' => $category->id]);
        Option::factory()->count(3)->create(['specification_id' => $specification->id]);

        $response = $this->getJson('/api/v1/catalog/options');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'value',
                        'filter',
                    ]
                ]
            ]);
    }

    public function test_option_store()
    {
        $category = Category::factory()->create();
        $specification = Specification::factory()->create(['leaf_category_id' => $category->id]);

        $data = [
            'value' => 'Test Option',
            'filter' => true,
            'specification_id' => $specification->id,
        ];

        $response = $this->postJson('/api/v1/catalog/options', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'value',
                'filter',
            ]);

        $this->assertDatabaseHas('options', [
            'filter' => $data['filter'],
            'specification_id' => $data['specification_id'],
        ]);
    }

    public function test_option_store_validation_fails()
    {
        $response = $this->postJson('/api/v1/catalog/options', [
            'value' => '', // Required field missing/invalid
            'filter' => 'not-a-boolean', // Invalid boolean
            'specification_id' => 'non-existent-id', // Invalid specification_id
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['value', 'filter', 'specification_id']);
    }

    public function test_option_update()
    {
        $category = Category::factory()->create();
        $specification = Specification::factory()->create(['leaf_category_id' => $category->id]);
        $option = Option::factory()->create(['specification_id' => $specification->id]);

        $updateData = [
            'value' => 'Updated Option',
            'filter' => false,
            'specification_id' => $specification->id,
        ];

        $response = $this->putJson("/api/v1/catalog/options/{$option->id}", $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('options', [
            'id' => $option->id,
            'filter' => $updateData['filter'],
            'specification_id' => $updateData['specification_id'],
        ]);
    }

    public function test_option_delete()
    {
        $category = Category::factory()->create();
        $specification = Specification::factory()->create(['leaf_category_id' => $category->id]);
        $option = Option::factory()->create(['specification_id' => $specification->id]);

        $response = $this->deleteJson("/api/v1/catalog/options/{$option->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('options', [
            'id' => $option->id,
        ]);
    }
}