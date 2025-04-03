<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class EvaluateSeeder extends Seeder
{
    public function run()
    {

        $user = User::find(3);
        $company = Company::find(2);
        $user->evaluations()->attach($company->id, [
            'rating' => 5,
        ]);
        $user = User::find(2);
        $company = Company::find(1);
        $company->evaluations()->attach($user->id, [
            'rating' =>2 ,
        ]);}}

/*
        $users = User::all();
        $companies = Company::all();

        foreach ($users as $user) {
            $company = $companies->random();
            $user->evaluations()->attach($company->id, [
                'rating' => rand(1, 5), // Donne une note aléatoire entre 1 et 5
            ]);
        }
    }
}
*/
