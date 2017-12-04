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
use App\Models\Product;
use Faker\Factory;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group product
     */

    public function test_user_can_visit_product_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/products')
            ->assertStatus(200);
    }

    /**
     * @group product
     */
    public function test_user_can_get_product_list()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/product-list', $this->postPaginate())
        ->assertStatus(200);
    }

    /**
     * @group product
     */
    public function test_user_can_add_product()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/product', $this->postData())
        ->assertStatus(201);
    }

    /**
     * @group product
     */
    public function test_user_can_update_product()
    {
        $user = User::find(2);
        $product = Product::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/product/'.$product->id, $this->postData())
        ->assertStatus(200);
    }

    /**
     * @group product
     */
    public function test_user_can_upload_product_photo()
    {
         Storage::fake('avatars');
         $user = User::find(2);
         $product = Product::find(1);
         $postData = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'id' => $product->id,
            'model' => 'product'
         ];
         $this->actingAs($user, 'api')
            ->json('post', '/api/media-upload', $postData)
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
        	'code' => $faker->unique()->ean8,
		    'name' => $faker->streetName,
		    'measurement' => $faker->word,
		    'price' => $faker->numberBetween(100000, 200000)
        ];
    }
}
