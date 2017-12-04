<?php

use Illuminate\Database\Seeder;
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
        for ($i=0; $i < 25; $i++) { 
            factory(Stokist::class)->create([
                'area_id' => rand(1,10)
            ]);
        }
    }
}
