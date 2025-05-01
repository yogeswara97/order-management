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
        $imageOptions = [
            'image/9yY3xUCrZa6ssgiPWGm4zjcMWB4zZhlFXl9QB2JV.jpg',
            'image/yrpHnwih8vrjywJujiApXyHVVuuaz7Ftwk6nZDyR.jpg',
        ];

        $unitPrice = $this->faker->numberBetween(10000, 500000);
        $quantity = $this->faker->numberBetween(1, 10);

        return [
            'order_id' => $this->faker->numberBetween(1, 30),
            'image' => $this->faker->randomElement($imageOptions),
            'item_name' => $this->faker->words(2, true),
            'code' => $this->faker->bothify('ITM-###??'),
            'description' => $this->faker->sentence(),
            'format' => $this->faker->randomElement(['PDF', 'DOCX', 'JPG']),
            'size_w' => $this->faker->randomFloat(1, 10, 100),
            'size_d' => $this->faker->randomFloat(1, 10, 100),
            'size_h' => $this->faker->randomFloat(1, 10, 100),
            'color' => $this->faker->safeColorName(),
            'quantity' => $quantity,
            'unit' => $this->faker->randomElement(['pcs', 'kg', 'm']),
            'unit_price' => (string) $unitPrice,
            'total_price' => (string) ($unitPrice * $quantity),
        ];
    }
}
