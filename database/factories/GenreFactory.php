<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
class GenreFactory extends Factory
{
 protected $model = Genre::class;
 public function definition()
 {
 return [
 'name' => ucfirst($this->faker->words(2, true)) ,
 ];
 }
}
