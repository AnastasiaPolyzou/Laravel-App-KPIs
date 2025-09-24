<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kpi;
use App\Models\Company;

class KpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        Company::all()->each(function ($company) {
            Kpi::factory()->count(5)->create([
                'company_id' => $company->id,
            ]);
        });
    }
}

