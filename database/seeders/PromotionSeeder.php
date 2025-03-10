<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        Promotion::factory()->count(2)->create();
    }
}
