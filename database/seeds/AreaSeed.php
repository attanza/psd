<?php

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::truncate();
        factory(Area::class, 4)->create();
    }
}
