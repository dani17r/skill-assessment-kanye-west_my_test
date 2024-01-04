<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\User;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_all_favorites_paginated()
    {
        $user = User::factory()->create();

        $responseQuotes = $this->actingAs($user)->get('/api/quotes');
        $quotes = json_decode($responseQuotes->getContent(), true);
        
        foreach ($quotes['data'] as $item) {
            $user->favorites()->create([
                'quote' => $item['quote'],
                'like' => $item['like'],
                'dislike' => $item['dislike'],
            ]);
        }
        
        $response = $this->actingAs($user)->get('/api/favorite/all');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [ 'id', 'quote', 'like', 'dislike', 'user_id' ]
            ],
            'first_page_url', 'from', 'last_page', 'last_page_url',
            'links' => [
                '*' => [ 'active', 'label', 'url' ]
            ],
            'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total',
        ]);
    }

    public function test_update_or_create_favorite()
    {
        $user = User::factory()->create();

        $requestData = [
            'like' => true,
            'dislike' => false,
            'quote' => 'Ejemplo de cita',
        ];

        $response = $this->actingAs($user)->post('/api/favorite', $requestData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'like' => true,
            'dislike' => false,
            'quote' => 'Ejemplo de cita',
            'user_id' => $user->id,
        ]);
    }

    public function test_delete_favorite()
    {
        $user = User::factory()->create();

        $favorite = Favorite::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post("/api/favorite/delete", ['quote' => $favorite->quote]);
        
        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', ['id' => $favorite->id]);
    }
}
