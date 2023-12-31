<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Favorite::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'like' => $this->faker->boolean,
      'dislike' => $this->faker->boolean,
      'quote' => $this->faker->sentence,
      'user_id' => \App\Models\User::factory(),
    ];
  }
}
