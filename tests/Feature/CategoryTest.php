<?php

namespace Tests\Feature;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\LabTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_all_category(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_it_lists_all_lab_paginated(): void
    {
        Category::factory()->count(11)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk()->assertJsonCount(10, 'data');
    }

    public function test_it_shows_a_single_category_with_lab_tests(): void
    {
        $category = Category::factory()->create();
        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertOk()
            ->assertJsonFragment(['id' => $category->id])
            ->assertJsonStructure(['data' => CategoryResource::JSON_STRUCTURE]);
    }

    public function test_it_can_create_a_category(): void
    {
        $name = 'Anemia';
        $data = [
            'name' => $name,
            'slug' => 'anemia',
        ];

        $response = $this->postJson('/api/categories', $data);

        $response->assertCreated()
            ->assertJsonFragment($data)
            ->assertJsonStructure(['data' => CategoryResource::JSON_STRUCTURE]);

        $this->assertDatabaseHas('categories', $data);
    }

    public function test_it_can_update_a_category(): void
    {
        $category = Category::factory()->create();

        $updateData = ['name' => 'Zmieniona', 'slug' => 'zmieniona'];

        $response = $this->putJson("/api/categories/{$category->id}", $updateData);

        $response->assertNoContent();

        $this->assertDatabaseHas('categories', ['id' => $category->id, ...$updateData]);
    }

    public function test_it_can_delete_a_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_it_cannot_delete_a_category_with_labs(): void
    {
        $category = Category::factory()->hasAttached(LabTest::factory()->count(3))->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
