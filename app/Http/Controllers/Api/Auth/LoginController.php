<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\AuthTrait;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use Auth;
use DB;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $params = $this->getParams($request);
        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_active' => 1
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
            return Route::dispatch($proxy);
        } else {
            return response()->json([
              'msg' => 'Login failed'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoke();
        return response()->json([], 204);
    }
}
