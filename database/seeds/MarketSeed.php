<?php

use Illuminate\Database\Seeder;
use App\Models\Market;

class MarketSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Market::truncate();
        for ($i=0; $i < 26; $i++) { 
            factory(Market::class)->create([
                'area_id' => rand(1,10)
            ]);
        }
    }
}
