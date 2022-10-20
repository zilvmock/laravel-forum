<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $faker = \Faker\Factory::create();
    $faker->addProvider(new FakerPicsumImagesProvider($faker));

    return [
      'first_name' => fake()->firstName(),
      'last_name' => fake()->lastName(),
      'avatar' => 'avatars/' . $faker->image(storage_path('app/public/avatars'), 100, 100, false, false),
      'username' => fake()->userName(),
      'bio' => fake()->paragraph(rand(3, 10)),
      'email' => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password' => Hash::make(fake()->password(8)),
      'remember_token' => Str::random(10),
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return static
   */
  public function unverified()
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
