<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Example test class for validating.
 */
class StoreLabTestValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_validates_missing_required_fields(): void
    {
        $response = $this->postJson('/api/lab-tests', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'slug', 'categories']);
    }

    public function test_it_validates_invalid_category_ids(): void
    {
        $response = $this->postJson('/api/lab-tests', [
            'name' => 'IgE całkowite',
            'categories' => ['not-an-id'],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['categories.0']);
    }

    public function test_it_passes_validation_with_valid_data(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/lab-tests', [
            'name' => 'IgE całkowite',
            'slug' => 'ige-calkowite',
            'description' => 'Opis badania',
            'categories' => [$category->id],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('lab_tests', ['name' => 'IgE całkowite']);
    }
}
