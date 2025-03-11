<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        Company::create([
            'name' => "Amazon",
            'email' => "amazon@amazon.com",
            'phone_number' => "0619462608",
            'description' => "Amazon is a global tech giant specializing in e-commerce, cloud computing (AWS), and digital services. Founded by Jeff Bezos in 1994, it revolutionized online shopping and logistics while expanding into AI, streaming, and smart devices.",
            'logo_path' =>"img/test/Amazon_logo.png",
        ]);
        Company::create([
            'name' => "Lego",
            'email' => "lego@lego.com",
            'phone_number' => "0652070291",
            'description' => "LEGO, founded in 1932, is a Danish toy company known for its interlocking bricks that inspire creativity. Beyond toys, it has expanded into video games, movies, and LEGOLAND parks, becoming a cultural icon in imaginative play.",
            'logo_path' =>"img/test/LEGO_logo.svg.png",
        ]);
        Company::create([
            'name' => "ThePokemonCompany",
            'email' => "tpc@tpc.com",
            'phone_number' => "0788335379",
            'description' => "The Pokémon Company, founded in 1998, manages the Pokémon franchise, including games, trading cards, and media. A joint venture of Nintendo, Game Freak, and Creatures, it oversees one of the most successful entertainment brands worldwide.",
            'logo_path' =>"img/test/International_Pokémon_logo.svg.png",
        ]);
        Company::factory(10)->create(); // Crée 10 compagnies
    }
}
