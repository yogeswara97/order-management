<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(), // Create a new order for each item
            'image' =>  $this->faker->randomElement(['image/1EUATSfejfNqzUV0U6zfRycgRx3hSR5zlvZYyS4g.png', 'image/2FWYXCUfS28eswlAUG5na6XeIm41c2g1eOC6ianN.png', 'image/TNdY6k1ZKHS9sQJA2DSS7eZtTle2DqnQBbJmiWk7.jpg']),
            'item_name' => $this->faker->word(),
            'code' => $this->faker->unique()->randomNumber(6),
            'description' => $this->faker->sentence(),
            'size_w' => $this->faker->randomFloat(2, 10, 100),
            'size_d' => $this->faker->randomFloat(2, 10, 100),
            'size_h' => $this->faker->randomFloat(2, 10, 100),
            'color' => $this->faker->colorName(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit' => $this->faker->randomElement(['kg', 'lb', 'm', 'cm']),
            'unit_price' => $this->faker->randomFloat(2, 1, 100),
            'total_price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }

    /**
     * Set the order_id to a specific value.
     *
     * @param int $orderId
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withOrderId(int $orderId)
    {
        return $this->state(function (array $attributes) use ($orderId) {
            return [
                'order_id' => $orderId,
            ];
        });
    }
}
