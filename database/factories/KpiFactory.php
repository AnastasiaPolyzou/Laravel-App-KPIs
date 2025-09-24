<?php

namespace Database\Factories;
use App\Models\Kpi;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kpi>
 */
class KpiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Kpi::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Sales', 'Income', 'Expenses', 'Goal satisfaction', 'Deviations'
            ]),
            'unit' => $this->faker->randomElement(['€', '%', 'number']),
            'company_id' => Company::inRandomOrder()->value('id') ?? Company::factory()->create()->id,
        ];
    }
}
