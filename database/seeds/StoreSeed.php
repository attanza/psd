<?php

use Illuminate\Database\Seeder;
use App\Models\Market;
use App\Models\Reseller;

class StoreSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Reseller::truncate();
        $markets = Market::all();
        foreach ($markets as $market) {
            factory(Reseller::class, 2)->create([
                'market_id' => $market->id,
                'parent_id' => 0,
                'reseller_type' => 'Store',
                'is_active' => 1
            ]);
        }
    }
}
