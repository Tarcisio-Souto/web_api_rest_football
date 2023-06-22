<?php

namespace Database\Seeders;

use App\Models\States;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        States::factory()->count(26)->create();
    }
}
