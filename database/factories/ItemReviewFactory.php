<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => function () {
                return Product::all()->random();
            },
            'user_id' => $this->faker->numberBetween(1, 6),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->realText,
        ];
    }
}
