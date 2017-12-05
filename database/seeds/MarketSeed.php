<?php

use Illuminate\Database\Seeder;
use App\Models\Area;
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
        $areas = Area::all();
        foreach ($areas as $area) {
            factory(Market::class, 2)->create([
                'area_id' => $area->id
            ]);
        }
    }
}
