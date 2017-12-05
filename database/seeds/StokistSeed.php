<?php

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Stokist;

class StokistSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stokist::truncate();
        $areas = Area::all();
        foreach ($areas as $area) {
            factory(Stokist::class)->create([
                'area_id' => $area->id
            ]);
        }
    }
}
