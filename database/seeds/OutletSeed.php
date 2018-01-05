<?php

use Illuminate\Database\Seeder;
use App\Models\Reseller;

class OutletSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedOutlet();
    }

    private function seedOutletBySeller()
    {
        
    }

    private function seedOutlet()
    {
        $stores = Reseller::where('parent_id', 0)->get();
        foreach ($stores as $store) {
            factory(Reseller::class)->create([
                'market_id' => $store->market_id,
                'parent_id' => $store->id,
                'reseller_type' => 'Outlet',
                'is_active' => 1
            ]);
        }
    }
}
