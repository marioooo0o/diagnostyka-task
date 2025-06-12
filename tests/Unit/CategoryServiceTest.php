<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Services\CategoryService;
use App\ValueObjects\CategoryCreateData;
use App\ValueObjects\CategoryUpdateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_category_from_value_object(): void
    {
        $valueObject = new CategoryCreateData(
            name: 'Hematologia',
            slug: 'hematoligia',
            description: 'Hematologia to dział medycyny zajmujący się chorobami krwi oraz układu krwiotwórczego.'
        );

        $service = new CategoryService();
        $test = $service->create($valueObject);

        $this->assertInstanceOf(Category::class, $test);
        $this->assertEquals('Hematologia', $test->name);
    }

    public function test_it_updates_category_from_value_object(): void
    {
        $category = Category::factory()->create();

        $valueObject = new CategoryUpdateData(
            name: 'Nowa nazwa',
            slug: 'nowa-nazwa',
        );

        $service = new CategoryService();
        $result = $service->update($category, $valueObject);

        $this->assertTrue($result);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Nowa nazwa',
            'slug' => 'nowa-nazwa',
        ]);
    }
}
