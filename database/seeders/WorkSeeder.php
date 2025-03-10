<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        $industries = Industry::all();




        foreach ($companies as $company) {
            $randomIndustries = $industries->random();
            $company->industries()->attach($randomIndustries);
        }


    }
}
