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
use App\Models\Area;
use App\Models\Market;
use App\Models\Reseller;
use Faker\Factory;

class OutletTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group outlet
     */

    public function test_user_can_visit_outlet_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/outlets')
            ->assertStatus(200);
    }

    /**
     * @group outlet
     */
    public function test_user_can_get_outlet_list()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/outlet-list', $this->postPaginate())
        ->assertStatus(200);
    }

    /**
     * @group outlet
     */
    public function test_only_seller_can_add_outlet()
    {
        $user = User::find(4);
        $this->actingAs($user, 'api')
        ->json('post', '/api/outlet', $this->postData())
        ->assertStatus(201);
    }

    /**
     * @group outlet
     */
    public function test_user_can_update_outlet()
    {
        $user = User::find(2);
        $outlet = Reseller::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/outlet/'.$outlet->id, $this->postData())
        ->assertStatus(200);
    }

    /**
     * @group outlet
     */
    public function test_user_can_get_area_list_for_select()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('get', '/api/area/for/combo')
        ->assertStatus(200);
    }

    /**
     * @group outlet
     */
    public function test_user_can_get_market_list_for_select()
    {
        $user = User::find(2);
        $area = Area::find(1);
        $this->actingAs($user, 'api')
        ->json('get', '/api/market/byArea/'.$area->id)
        ->assertStatus(200);
    }

    /**
     * @group outlet
     */
    public function test_user_can_upload_outlet_photo()
    {
         Storage::fake('avatars');
         $user = User::find(2);
         $outlet = Reseller::find(1);
         $postData = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'id' => $outlet->id,
            'model' => 'outlet'
         ];
         $this->actingAs($user, 'api')
            ->json('post', '/api/media-upload', $postData)
            ->assertStatus(200);
    }

    /**
     * @group outlet
     */
    public function test_user_can_update_outlet_location()
    {
        $user = User::find(2);
        $outlet = Reseller::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/outlet/'.$outlet->id.'/location', $this->postLocation())
        ->assertStatus(200);
    }

    private function postPaginate()
    {
        return [
            'paginate' => 10,
            'searchQ' => "",
            'market_id'
        ];
    }

    private function postData()
    {
        $faker = Factory::create();
        return [
        	'market_id' => 1,
        	'parent_id' => 1,
        	'reseller_type' => 'Outlet',
            'code' => $faker->unique()->ean8,
		    'name' => $faker->company,
		    'owner' => $faker->name,
		    'pic' => $faker->name,
		    'phone1' => $faker->e164PhoneNumber,
		    'phone2' => $faker->e164PhoneNumber,
		    'email' => $faker->unique()->email,
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
