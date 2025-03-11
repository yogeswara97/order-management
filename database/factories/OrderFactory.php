<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => 1,
            'order_date' => $this->faker->dateTimeBetween('2024-02-01', '2025-03-31')->format('Y-m-d'),
            'reference_number' => $this->faker->unique()->randomNumber(8),
            'order_number' => $this->faker->unique()->randomNumber(6),
            'object' => $this->faker->word(),
            'cargo' => $this->faker->word(),
            'status' => $this->faker->randomElement(['new', 'quotation', 'invoice']),
            'currency' => $this->faker->randomElement(['usd', 'idr', 'eur']),
            'total' => $this->faker->randomFloat(2, 10, 1000),
            'vat' => $this->faker->randomFloat(2, 0, 99),
            'grand_total' => $this->faker->randomFloat(2, 10, 1200),
            'deposit_amount' => $this->faker->randomFloat(2, 0, 500),
            'deposit_description' => $this->faker->sentence(),
            'terms_conditions' => $this->faker->paragraph(),
        ];
    }
}
