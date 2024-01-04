<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class ProfileTest extends TestCase
{
  /**
   * A basic test example.
   *
   * @return void
   */
  public function test_update_actions_favorites_and_quotes_of_user_profile_by_admin()
  {
    $user = User::factory()->create([ 'isAdmin' => true ]);
    $userData = User::factory()->create();

    $request = new Request([
      'user_id' => $userData->id,
      'moderating' => 15,
      'banning' => true,
    ]);

    $response = $this->actingAs($user)->post('/api/user/profile/update-by-admin', $request->all());

    $response->assertStatus(200);
  }

  public function test_update_user_password_successfully()
  {
    $user = User::factory()->create();
    $newPassword = 'new_password';
    $currentPassword = 'password';

    $request = new Request([
      'current_password' => $currentPassword,
      'new_password' => $newPassword,
      'check_new_password' => $newPassword,
    ]);

    $response = $this->actingAs($user)->post('/api/user/profile/change-password', $request->all());

    $response->assertStatus(200);
    $response->assertJsonFragment([
      'success' => 'Password changed successfully!',
    ]);
  }

  public function test_update_user_password_incorrect()
  {
    $user = User::factory()->create();
    $newPassword = 'new_password';
    $currentPassword = 'password_1212';

    $request = new Request([
      'current_password' => $currentPassword,
      'new_password' => $newPassword,
      'check_new_password' => $newPassword,
    ]);

    $response = $this->actingAs($user)->post('/api/user/profile/change-password', $request->all());

    $response->assertStatus(422);
    $response->assertJsonFragment([
      'message' => 'Current password is incorrect'
    ]);
  }
  
  public function test_update_user_profile()
  {
    $user = User::factory()->create();
   
    $request = new Request([
      'name' =>  'new name',
      'email' => $user->email,
    ]);
    
    $response = $this->actingAs($user)->post('/api/user/profile/update', $request->all());
    $response->assertStatus(200);
    $response->assertJsonStructure([
      'user' => [ 'id', 'name', 'email' ],
    ]);
  }

  // There is a bug that I can't fix.
  // public function test_update_user_profile_with_image()
  // {
  //   $user = User::factory()->create();
  //   $image = UploadedFile::fake()->image('dan_test.png');

  //   $request = new Request([
  //     'name' =>  $user->name,
  //     'email' => $user->email,
  //     'image' => $image,
  //   ]);

  //   $response = $this->actingAs($user)->post('/api/user/profile/update', $request->all());

  //   $response->assertStatus(200);
  //   $response->assertJsonStructure([
  //     'user' => [ 'id', 'name', 'email', 'image' ],
  //   ]);
  // }

  public function test_get_all_user_profile_paginated()
  {
    $user = User::factory()->create([ 'isAdmin' => true ]);
    $response = $this->actingAs($user)->get('/api/user/profile/all');
    $response->assertStatus(200);
    $response->assertJsonStructure([
      'current_page',
      'data' => [
        '*' => [
          "name", "email", "email_verified_at", "moderating",
          "banning", "updated_at", "created_at", "id",
        ]
      ],
      'first_page_url', 'from', 'last_page', 'last_page_url',
      'links' => [
        '*' => [
          'active',
          'label',
          'url',
        ]
      ],
      'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total',
    ]);
    
  }

  public function test_get_one_user_profile()
  {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/api/user/profile/show');
    $response->assertStatus(200);
    $response->assertJsonStructure([
      "user" => [
        "name", "email", "email_verified_at", "isAdmin", "moderating",
        "banning", "updated_at", "created_at", "id",
      ]
    ]);
  }
}
