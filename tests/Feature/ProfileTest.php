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
use Faker\Factory;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group profile
     */

    public function test_user_can_visit_profile()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/profile')
            ->assertStatus(200);
    }

    /**
     * @group profile
     */
    public function test_user_can_upload_profile_photo()
    {
         Storage::fake('avatars');
         $user = User::find(2);
         $postData = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'id' => $user->id,
            'model' => 'user'
         ];
         $this->actingAs($user, 'api')
            ->json('post', '/api/media-upload', $postData)
            ->assertStatus(200);
    }

    /**
     * @group profile
     */
    public function test_user_can_update_profile()
    {
         $user = User::find(2);
         $this->actingAs($user, 'api')
            ->json('put', '/api/profile', $this->postData())
            ->assertStatus(200);
    }

    private function postData()
    {
        $faker = Factory::create();
        return [
            'name' => $faker->name,
            'email' => $faker->safeEmail,
        ];
    }
}
