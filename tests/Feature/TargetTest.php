<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\Models\target;
use Faker\Factory;
use App\Models\SellTarget;
use Carbon\Carbon;
use App\Models\Product;

class TargetTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group target
     */

    public function test_user_can_visit_target_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/sell-targets')
            ->assertStatus(200);
    }

    /**
     * @group target
     */
    public function test_user_can_get_target_list()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/sell-target-list', $this->postPaginate())
        ->assertStatus(200);
    }

    /**
     * @group target
     */
    public function test_user_can_add_target()
    {
        $user = User::find(2);
        // dd($this->postData());
        $this->actingAs($user, 'api')
        ->json('post', '/api/sell-target', $this->postData())
        ->assertStatus(201);
    }

    /**
     * @group target
     */
    // public function test_user_can_update_target()
    // {
    //     $user = User::find(2);
    //     $target = target::find(1);
    //     $this->actingAs($user, 'api')
    //     ->json('put', '/api/target/'.$target->id, $this->postData())
    //     ->assertStatus(200);
    // }

    private function postPaginate()
    {
        return [
            'paginate' => 10,
            'searchQ' => ""
        ];
    }

    private function postData()
    {
    	$product = Product::find(1);
        $faker = Factory::create();
        return [
            'name' => 'Sell Target for '.$product->name.'for this month',
			'product_id' => $product->id,
            'area_id' => 1,
			'target_by' => 'Outlet',
			'target_count' => 50,
			'start_date' => Carbon::now()->format('Y-m-d'),
			'end_date' => Carbon::now()->addMonths(6)->format('Y-m-d'),
			'status' => 'Open'
        ];
    }
}
