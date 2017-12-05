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
use App\Models\Stokist;
use Faker\Factory;

class StokistTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group stokist
     */

    public function test_user_can_visit_stokist_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/stokists')
            ->assertStatus(200);
    }

    /**
     * @group stokist
     */
    public function test_user_can_get_stokist_list()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/stokist-list', $this->postPaginate())
        ->assertStatus(200);
    }

    /**
     * @group stokist
     */
    public function test_user_can_add_stokist()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/stokist', $this->postData())
        ->assertStatus(201);
    }

    /**
     * @group stokist
     */
    public function test_user_can_update_stokist()
    {
        $user = User::find(2);
        $stokist = stokist::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/stokist/'.$stokist->id, $this->postData())
        ->assertStatus(200);
    }

    /**
     * @group stokist
     */
    public function test_user_can_get_area_list_for_select()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('get', '/api/area/for/combo')
        ->assertStatus(200);
    }

    /**
     * @group stokist
     */
    public function test_user_can_upload_stokist_photo()
    {
         Storage::fake('avatars');
         $user = User::find(2);
         $stokist = Stokist::find(1);
         $postData = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'id' => $stokist->id,
            'model' => 'stokist'
         ];
         $this->actingAs($user, 'api')
            ->json('post', '/api/media-upload', $postData)
            ->assertStatus(200);
    }

    /**
     * @group stokist
     */
    public function test_user_can_update_stokist_location()
    {
        $user = User::find(2);
        $stokist = Stokist::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/stokist/'.$stokist->id.'/location', $this->postLocation())
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
        	'area_id' => 1,
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
