<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\LabTest;
use App\Strategies\Filters\FilterByCreatedAt;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterByCreatedAtTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_filters_lab_tests_by_created_at(): void
    {
        $labTestA = LabTest::factory()->hasAttached(Category::factory()->count(2)->create())->create([
            'created_at' => Carbon::parse('2025-01-01 10:00:00'),
        ]);
        $labTestB = LabTest::factory()->hasAttached(Category::factory()->count(2)->create())->create([
            'created_at' => Carbon::parse('2025-06-12 15:30:00'),
        ]);

        $query = LabTest::query();
        $filtered = (new FilterByCreatedAt)->apply($query, ['from' => '2025-06-12'])->get();

        $this->assertCount(1, $filtered);
        $this->assertTrue($filtered->first()->is($labTestB));
    }

    public function test_it_filters_lab_tests_by_created_at_from_out_of_range(): void
    {
        LabTest::factory()->hasAttached(Category::factory()->count(2)->create())->create([
            'created_at' => Carbon::parse('2025-01-01 10:00:00'),
        ]);
        LabTest::factory()->hasAttached(Category::factory()->count(2)->create())->create([
            'created_at' => Carbon::parse('2025-06-12 15:30:00'),
        ]);

        $query = LabTest::query();
        $filtered = (new FilterByCreatedAt)->apply($query, ['from' => '2025-06-15'])->get();

        $this->assertCount(0, $filtered);
        $this->assertTrue($filtered->isEmpty());
    }

    public function test_it_filters_category_by_created_at_from_range(): void
    {
        $labTestA = LabTest::factory()->create([
            'created_at' => Carbon::parse('2025-01-01 10:00:00'),
        ]);

        $labTestB = LabTest::factory()->create([
            'created_at' => Carbon::parse('2025-06-12 15:30:00'),
        ]);

        $query = LabTest::query();
        $filtered = (new FilterByCreatedAt)->apply($query, ['from' => '2024-06-01', 'to' => '2025-06-15'])->get();

        $this->assertCount(2, $filtered);
        $this->assertTrue($filtered->contains(fn ($item) => $item->id === $labTestA->id));
        $this->assertTrue($filtered->contains(fn ($item) => $item->id === $labTestB->id));
    }
}
