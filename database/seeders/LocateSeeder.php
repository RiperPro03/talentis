<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Address;

class LocateSeeder extends Seeder
{
    public function run()
    {
        $companies = Company::all();
        $addresses = Address::all();

        foreach ($companies as $company) {
            $address = $addresses->random();
            $company->located()->attach($address->id);
        }
    }
}
