<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DrinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_drink_list(): void
    {
        $response = $this->getJson('/api/v1/drinks');

        $response->assertStatus(200);
    }
}
