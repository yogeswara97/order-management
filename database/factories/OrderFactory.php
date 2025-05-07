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
        $statusOptions = array_merge(
            array_fill(0, 10, 'new'),
            array_fill(0, 15, 'quotation'),
            array_fill(0, 25, 'invoice'),
            array_fill(0, 40, 'paid'),
            array_fill(0, 10, 'cancelled'),
        );
        return [
            // 'customer_id' => 1,
            'customer_id' => $this->faker->numberBetween(1, 10),
            // 'customer_id' => null,
            'order_date' => $this->faker->dateTimeBetween('2023-02-01', '2025-05-31')->format('Y-m-d'),
            'reference_number' => $this->faker->unique()->randomNumber(8),
            'order_number' => $this->faker->unique()->randomNumber(6),
            'object' => $this->faker->word(),
            'cargo' => $this->faker->word(),
            'continent' => $this->faker->randomElement(['asia', 'europe', 'america', 'africa', 'australia']),
            'status' => $this->faker->randomElement($statusOptions),
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
