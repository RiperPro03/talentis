<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class EvaluateSeeder extends Seeder
{
    public function run()
    {
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
