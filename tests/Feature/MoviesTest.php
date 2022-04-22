<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MoviesTest extends TestCase
{
    /**
     * to test api connect successullty
     *
     * @return void
     */
    public function testMovieApi()
    {
        $user = User::factory()->create();

        $fakeApiResponse = file_get_contents(storage_path('tests/api-response.json'));

        Http::fake([
            'https://www.omdbapi.com/?t=spider&plot=full&apikey=72863d1e' => Http::response(
                json_decode($fakeApiResponse, true),
                200
            ),
        ]);

        $response = $this->actingAs($user)
        ->getJson('api/movies')
        ->assertStatus(200);
    }
}
