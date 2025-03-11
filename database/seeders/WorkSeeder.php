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
        $company = Company::find(1);
        $industry = Industry::find(1);
        $company->industries()->attach($industry);
        $industry = Industry::find(6);
        $company->industries()->attach($industry);
        $company = Company::find(2);
        $industry = Industry::find(6);
        $company->industries()->attach($industry);}}




/*
        $companies = Company::all();
        $industries = Industry::all();




        foreach ($companies as $company) {
            $randomIndustries = $industries->random();
            $company->industries()->attach($randomIndustries);
        }


    }
}
*/
