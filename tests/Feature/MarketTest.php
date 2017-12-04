<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Market;
use Faker\Factory;

class MarketTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group market
     */

    public function test_user_can_visit_market_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/markets')
            ->assertStatus(200);
    }

     /**
     * @group market
     */
    public function test_user_can_get_market_list()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/market-list', $this->postPaginate())
        ->assertStatus(200);
    }

    /**
     * @group market
     */
    public function test_user_can_add_market()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/market', $this->postData())
        ->assertStatus(201);
    }

    /**
     * @group market
     */
    public function test_user_can_update_market()
    {
        $user = User::find(2);
        $market = Market::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/market/'.$market->id, $this->postData())
        ->assertStatus(200);
    }

    /**
     * @group market
     */
    public function test_user_can_get_area_list_for_select()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('get', '/api/area/for/combo')
        ->assertStatus(200);
    }

    /**
     * @group market
     */
    public function test_user_can_upload_market_photo()
    {
         Storage::fake('avatars');
         $user = User::find(2);
         $market = Market::find(1);
         $postData = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'id' => $market->id,
            'model' => 'market'
         ];
         $this->actingAs($user, 'api')
            ->json('post', '/api/media-upload', $postData)
            ->assertStatus(200);
    }

    /**
     * @group market
     */
    public function test_user_can_update_market_location()
    {
        $user = User::find(2);
        $market = Market::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/market/'.$market->id.'/location', $this->postLocation())
        ->assertStatus(200);
    }

    private function postPaginate()
    {
        return [
            'paginate' => 10,
            'searchQ' => ""
        ];
    }

    private function postData()
    {
        $faker = Factory::create();
        return [
        	'area_id' => rand(1,10),
            'name' => $faker->city,
		    'address' => $faker->address,
		    'lat' => $faker->latitude,
		    'lng' => $faker->longitude,
        ];
    }

    private function postLocation()
    {
        $faker = Factory::create();
        return [
            'lat' => $faker->latitude,
            'lng' => $faker->longitude
        ];
    }
}
