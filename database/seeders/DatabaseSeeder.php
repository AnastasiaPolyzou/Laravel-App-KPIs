<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\KpiSeeder;
use Database\Seeders\MeasurementsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $companies = Company::factory(10)->create();
        
        
        User::factory(50)->create()->each(function($user) use ($companies){
            $user->company_id = $companies->random()->id;
            $user->save();
        });
        
        $companyId = $companies->random()->id;
       
        $this->call([
            KpiSeeder::class,
            MeasurementsSeeder::class,
        ]);

         User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'password' => Hash::make('password'),
             'company_id' => $companyId,
         ]);
    }
}
