<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\Models\Area;
use Faker\Factory;

class AreaTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group area
     */

    public function test_user_can_visit_area_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/areas')
            ->assertStatus(200);
    }

    /**
     * @group area
     */
    public function test_user_can_get_area_list()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/area-list', $this->postPaginate())
        ->assertStatus(200);
    }

    /**
     * @group area
     */
    public function test_user_can_add_area()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
        ->json('post', '/api/area', $this->postData())
        ->assertStatus(201);
    }

    /**
     * @group area
     */
    public function test_user_can_update_area()
    {
        $user = User::find(2);
        $area = Area::find(1);
        $this->actingAs($user, 'api')
        ->json('put', '/api/area/'.$area->id, $this->postData())
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
            'name' => $faker->city,
            'description' => $faker->sentence
        ];
    }
}
