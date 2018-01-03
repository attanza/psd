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
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use Faker\Factory;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group users
     */

    public function test_user_can_access_users()
    {
        $user = User::find(2);
        $this->actingAs($user)
            ->get('/users')
            ->assertStatus(200);
    }

    /**
     * @group users
     */
    public function test_user_can_update_users()
    {
         $user = User::find(2);
         $this->actingAs($user, 'api')
            ->json('put', '/api/user/'.$user->id, $this->postData())
            ->assertStatus(200);
    }

    /**
     * @group users
     */
    public function test_user_can_reset_password()
    {
        $user = User::find(2);
        $resetUser = User::find(3);
        $hash = str_random(6);
        Mail::fake();

        $this->actingAs($user, 'api')
            ->json('get', 'api/reset-password/'.$resetUser->id)
            ->assertStatus(200);

        Mail::assertQueued(ResetPasswordMail::class, function ($mail) use ($resetUser, $hash) {
            return $mail->user->id === $resetUser->id;
        });

        Mail::assertQueued(ResetPasswordMail::class, function ($mail) use ($resetUser) {
            return $mail->hasTo($resetUser->email);
        });
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
