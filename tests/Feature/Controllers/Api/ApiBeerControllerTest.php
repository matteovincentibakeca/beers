<?php

namespace Tests\Feature;

use App\Http\Services\Interfaces\BeerServiceInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ApiBeerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and generate a token for them
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-api-token')->plainTextToken;
    }

    protected function authenticatedJsonGet($url)
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->getJson($url);
    }

    public function testSuccessfulBeerListRetrieval()
    {
        // Mock the BeerServiceInterface to return predefined data
        $this->mock(BeerServiceInterface::class, function ($mock) {
            $mock->shouldReceive('getPaginatedBeerList')
                ->andReturn(collect([]));
        });

        $response = $this->authenticatedJsonGet('/api/beers');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'OK',
        ]);
        $response->assertJsonStructure(['data']);
    }

    public function testCaching()
    {
        Cache::shouldReceive('remember')
            ->twice()
            ->andReturn(collect([]));

        $this->authenticatedJsonGet('/api/beers');
        $this->authenticatedJsonGet('/api/beers');
    }

    public function testErrorHandling()
    {
        $this->mock(BeerServiceInterface::class, function ($mock) {
            $mock->shouldReceive('getPaginatedBeerList')
                ->andThrow(new \Exception('An error occurred'));
        });

        $response = $this->authenticatedJsonGet('/api/beers');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'message' => 'An error occurred',
        ]);
    }

    public function testCacheExpiry()
    {
        $this->mock(BeerServiceInterface::class, function ($mock) {
            $mock->shouldReceive('getPaginatedBeerList')
                ->times(2)  // We expect it to be called twice
                ->andReturn(collect([]));
        });

        // First call
        $this->authenticatedJsonGet('/api/beers');

        // Sleep for a little over 1 minute to let the cache expire
        sleep(65);

        // Second call
        $this->authenticatedJsonGet('/api/beers');
    }
}
