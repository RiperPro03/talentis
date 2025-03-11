<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Address;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Prime',
            'profile_picture_path' => 'C:/Users/enzoc/talentis/public/img/test/Miniature_PP_Plus_EV.png',
            'first_name' => 'Argan',
            'email' => 'arganprime@viacesi.fr',
            'password' => bcrypt('password'),
            'birthdate' => '2005-10-04',
            'promotion_id' => 1,
            'address_id' => 1,
        ]);
        User::create([
            'name' => 'Prime',
            'profile_picture_path' => 'C:/Users/enzoc/talentis/public/img/test/images_pp.png',
            'first_name' => 'Autiste',
            'email' => 'autisteprime@viacesi.fr',
            'password' => bcrypt('password'),
            'birthdate' => '2005-12-02',
            'promotion_id' => 2,
            'address_id' => 2,
        ]);
        User::create([
            'name' => 'Fatou',
            'profile_picture_path' => 'C:/Users/enzoc/talentis/public/img/test/image2.jpg',
            'first_name' => 'Sow',
            'email' => 'fatousow@gmail.com',
            'password' => bcrypt('password'),
            'birthdate' => '2017-08-28',
            'promotion_id' => 1,
            'address_id' => 1,
        ]);
        for ($i = 1; $i <= 5; $i++) {
            $address = Address::inRandomOrder()->first(); // Crée une adresse
            $promotion = Promotion::inRandomOrder()->first(); // Crée une promotion


        User::factory(1)->create([
            'address_id' => $address->id,
            'promotion_id' => $promotion->id,
        ]);


    }

    }
}
