<?php

namespace Tests\Feature;

use App\Models\GolfCourse;
use Tests\TestCase;

class GolfCourseFeatureTest extends TestCase
{
    public function test_index_page_returns_successfully(): void
    {
        $response = $this->get(route('golf-courses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('golf-courses.index');
    }

    public function test_create_page_returns_successfully(): void
    {
        $response = $this->get(route('golf-courses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('golf-courses.create');
    }

    public function test_index_search_filters_by_keyword_and_prefecture(): void
    {
        GolfCourse::factory()->create([
            'course_name' => 'Test Course A',
            'address' => '東京都新宿区',
            'locale' => 'ja',
            'country_code' => 'JP',
            'state_prefecture' => '東京都',
            'indoor' => true,
        ]);

        GolfCourse::factory()->create([
            'course_name' => 'Other Course',
            'address' => '大阪府大阪市',
            'locale' => 'ja',
            'country_code' => 'JP',
            'state_prefecture' => '大阪府',
            'indoor' => false,
        ]);

        $response = $this->get(route('golf-courses.index', [
            'q' => 'Test',
            'prefecture' => '東京都',
            'locale' => 'ja',
            'kind' => 'indoor',
        ]));

        $response->assertOk();
        $response->assertSee('Test Course A');
        $response->assertDontSee('Other Course');
    }
}
