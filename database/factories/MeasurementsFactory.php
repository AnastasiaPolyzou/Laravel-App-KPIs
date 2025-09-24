<?php

namespace Database\Factories;


use App\Models\Measurements;
use App\Models\User;
use App\Models\Company;
use App\Models\Kpi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Measurements>
 */
class MeasurementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Measurements::class;
    public function definition()
  {
    $company = Company::inRandomOrder()->first();

    $kpi = $company->kpis()->inRandomOrder()->first();

    $user = $company->users()->inRandomOrder()->first();

    return [
        'company_id' => $company->id,
        'user_id' => $user->id,
        'kpi_id' => $kpi->id,
        'date' => $this->faker->date(),
        'value' => $this->faker->randomFloat(2, 0, 1000),
    ];
   }
}
