<?php

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Market;
use App\Models\Stokist;
use App\Models\Product;
use App\Models\SellTarget;
use Carbon\Carbon;

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
        $this->targetSeed();
    }

    private function areaSeed()
    {
    	Area::truncate();
        Market::truncate();
        Stokist::truncate();

        $areas = $this->areas();

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

        $products = $this->products();
        foreach ($products as $product) {
        	factory(Product::class)->create([
        		'name' => $product,
        		'measurement' => 'Bottle',
        		'price' => rand(10000,15000)
        	]);
        }
    }

    private function targetSeed()
    {
      SellTarget::truncate();
      $areas = Area::select('id')->get()->count();
      $products = Product::all();
      foreach ($products as $product) {
        $num = rand(1,2);
        switch ($num) {
          case 1:
            $targetBy = 'Outlet';
            $targetNum = rand(40, 60);
            break;
          case 2:
            $targetBy = 'Quantity';
            $targetNum = rand(1000, 5000);
            break;
        }
        $areaId = rand(1, $areas);
        SellTarget::create([
          'name' => 'Sell Target for '.$product->name,
          'product_id' => $product->id,
          'area_id' => $areaId,
          'target_by' => $targetBy,
          'target_count' => $targetNum,
          'start_date' => Carbon::now(),
          'end_date' => Carbon::now()->addMonths(6),
          'status' => 'Open'
        ]);
      }
    }

    private function areas()
    {
      return [
        [
          'name' => 'Serang, Banten',
          'markets' => ['Pasar Merak', 'Pasar Kranggot', 'Pasar Rangkas Bitung'],
          'stokists' => ['SPS']
        ],
        [
          'name' => 'Tangerang',
          'markets' => ['Pasar Cikupa', 'Pasar Malabar', 'Pasar Anyar'],
          'stokists' => ['Tri Putra']
        ],
        [
          'name' => 'Jakarta Barat',
          'markets' => ['Pasar Kropo', 'Pasar Cengkareng', 'Pasar Jembatan Dua'],
          'stokists' => ['UGS Daan Mogot']
        ],
        [
          'name' => 'Jakarta Selatan',
          'markets' => ['Pasar Minggu', 'Pasar Kebayoran Lama'],
          'stokists' => ['UGS Lenteng Agung']
        ],
        [
          'name' => 'Cikampek',
          'markets' => ['Pasar PEMDA'],
          'stokists' => ['RPS']
        ]
      ];
    }

    private function products() {
      return ['Oyster Sauce', 'Chili Sauce', 'Soy Sauce'];
    }
}
