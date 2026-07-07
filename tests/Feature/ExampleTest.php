<?php

namespace Tests\Feature;

use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        Banner::create([
            'title' => 'Test Banner',
            'link' => '/products',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
