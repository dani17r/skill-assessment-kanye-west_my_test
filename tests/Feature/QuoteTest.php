<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use App\Models\User;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_quote_returns_a_successful_response()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/quotes');
        $response->assertStatus(200);
    }

    public function test_quote_returns_a_unique_random_quotes()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/quotes?limit=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_favorites',
            'data' => [
                '*' => [
                    'dislike',
                    'quote',
                    'like',
                ]
            ]
        ]);
    }

    public function test_avoid_repeating_a_quote_more_than_once()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/quotes?limit=10');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true)['data'];
        $quoteCount = [];
        foreach ($data as $quote) {
            if (array_key_exists($quote['quote'], $quoteCount)) {
                $quoteCount[$quote['quote']]++;
            } else {
                $quoteCount[$quote['quote']] = 1;
            }
        }

        foreach ($quoteCount as $quote => $count) {
            $this->assertLessThanOrEqual(2, $count, "Quote '$quote' appears more than twice.");
        }
    }

    public function test_min_throttle_middleware()
    {
        $user = User::factory()->create();
       
        for ($i=0; $i < 29; $i++) { 
            $response = $this->actingAs($user)->get('/api/quotes');
        }

        $response->assertStatus(200);
    }
    
    public function test_max_throttle_middleware()
    {
        $user = User::factory()->create();
       
        for ($i=0; $i < 31; $i++) { 
            $response = $this->actingAs($user)->get('/api/quotes');
        }

        $response->assertStatus(429);
    }
}
