<?php

namespace Tests\Feature;

use App\Http\Resources\LabTestResource;
use App\Models\Category;
use App\Models\LabTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabTestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_lab(): void
    {
        LabTest::factory()->count(3)->create();

        $response = $this->getJson('/api/lab-tests');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_it_can_create_a_lab(): void
    {
        $categories = Category::factory()->count(2)->create();

        $data = [
            'name' => 'Blood Test',
            'slug' => 'blood-test',
            'description' => 'Basic blood test',
            'test_preparation' => 'Fasting required',
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/lab-tests', $data);

        $response->assertCreated()
            ->assertJsonFragment([
                'name' => 'Blood Test',
                'slug' => 'blood-test',
            ])
            ->assertJsonStructure(['data' => LabTestResource::JSON_STRUCTURE]);

        $this->assertDatabaseHas('lab_tests', ['name' => 'Blood Test']);
        $this->assertEquals(2, LabTest::first()->categories()->count());
    }

    public function test_it_can_show_a_single_lab(): void
    {
        $labTest = LabTest::factory()->create();

        $response = $this->getJson("/api/lab-tests/{$labTest->id}");

        $response->assertOk()
            ->assertJsonFragment(['id' => $labTest->id]);
    }

    public function test_it_can_update_a_lab(): void
    {
        $labTest = LabTest::factory()->create([
            'name' => 'Old Name',
        ]);

        $response = $this->putJson("/api/lab-tests/{$labTest->id}", [
            'name' => 'New Name',
            'slug' => $labTest->slug, // unchanged
            'categories' => [],
        ]);

        $response->assertNoContent();

        $this->assertDatabaseHas('lab_tests', ['name' => 'New Name']);
        $this->assertEquals(0, $labTest->categories()->count());
    }

    public function test_it_can_delete_a_lab(): void
    {
        $labTest = LabTest::factory()->create();

        $response = $this->deleteJson("/api/lab-tests/{$labTest->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('lab_tests', ['id' => $labTest->id]);
    }

    public function test_it_cannot_delete_a_lab_with_categories(): void
    {
        $labTest = LabTest::factory()->hasAttached(Category::factory()->count(2))->create();

        $response = $this->deleteJson("/api/lab-tests/{$labTest->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('lab_tests', ['id' => $labTest->id]);
    }

    public function test_it_validates_required_fields_on_store(): void
    {
        $response = $this->postJson('/api/lab-tests', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'slug', 'categories']);
    }
}
