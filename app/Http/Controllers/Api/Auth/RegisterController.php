<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Activation;
use Carbon\Carbon;
use DB;

class RegisterController extends Controller
{
    use AuthTrait;

    protected $code;

    public function __construct()
    {
        $this->code = str_random(4);
    }

    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:30|unique:users',
            'password' => 'required|min:6'
        ]);

        $this->createUser($request);
        return response()->json([
            'activation_code' => $this->code,
            'phone' => $request->phone,
            'password' => $request->password
        ], 200);
    }

    private function createUser($r)
    {
        $user = User::create([
            'phone' => $r->phone,
            'password' => bcrypt($r->password),
            'is_active' => 0,
            'name' => $r->phone,
        ]);

        Activation::create([
            'user_id' => $user->id,
            'code' => $user->phone.$this->code,
            'completed' => 0
        ]);

        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
