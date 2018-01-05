<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\SellTarget;
use App\Models\SellerTarget;

class SellerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedSeller();
        $this->seedSellerTarget();
    }

    private function seedSeller()
    {
    	$this->truncateSeller();

    	for ($i=0; $i < 6; $i++) { 
    		$seller = factory(User::class)->create();
    		$seller->roles()->attach(4);
    	}
    }

    private function seedSellerTarget()
    {
    	SellerTarget::truncate();

    	$targets = $this->getTargets();
    	$sellers = $this->getSeller();
    	$countSellers = count($sellers);
    	$countTargets = count($targets);
    	$i = 1;

    	foreach ($sellers as $seller) {
    		$targetId = rand(1,$countTargets);
    		$target = SellTarget::find($targetId);
    		$targetCount = ($target->target_count) / $countSellers;
    		SellerTarget::create([
    			'seller_id' => $seller->id,
    			'target_id' => $target->id,
    			'target_count' => $targetCount,
    			'start_date' => $target->start_date,
    			'end_date' => $target->end_date,
    			'status' => 'Open'
    		]);
    	}

    }

    private function truncateSeller()
    {
    	$sellers = $this->getSeller();
    	if (count($sellers) > 0) {
    		foreach ($sellers as $seller) {
    			$seller->roles()->detach();
    			$seller->delete();
    		}
    	}
    }

    private function getSeller()
    {
    	$sellers = User::whereHas('roles', function($query) {
    		$query->where('name', 'seller');
    	})->get();

    	return $sellers;
    }

    private function getTargets()
    {
    	$targets = SellTarget::all();
    	return $targets;
    }
}
