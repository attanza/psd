<?php

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Market;
use App\Models\Stokist;
use App\Models\Product;

class PsdSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->areaSeed();
        $this->productSeed();
    }

    private function areaSeed()
    {
    	Area::truncate();
        Market::truncate();
        Stokist::truncate();

        $areas = config('psd_seeder.areas');

        foreach ($areas as $area) {
          $name = $area['name'];
          $markets = $area['markets'];
          $stokists = $area['stokists'];

          $area = factory(Area::class)->create([
            'name' => $name
          ]);
          foreach ($markets as $market) {
            factory(MArket::class)->create([
              'area_id' => $area->id,
              'name' => $market
            ]);
          }
          foreach ($stokists as $stokist) {
            factory(Stokist::class)->create([
              'area_id' => $area->id,
              'name' => $stokist
            ]);
          }
        }
    }

    private function productSeed()
    {
    	Product::truncate();

        $products = config('psd_seeder.products');
        foreach ($products as $product) {
        	factory(Product::class)->create([
        		'name' => $product,
        		'measurement' => 'Bottle',
        		'price' => rand(10000,15000)
        	]);
        }
    }
}
