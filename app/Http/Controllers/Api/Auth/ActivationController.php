<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Activation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthTrait;
use Auth;

class ActivationController extends Controller
{
    use AuthTrait;

    public function activate(Request $request)
    {
        $request->validate([
            'activation_code' => 'required|size:4',
            'phone' => 'required|numeric',
            'password' => 'required'
        ]);

        if ($this->findActivation($request)) {
            $this->activateUser($request);
            $login = $this->logUserIn($request);
            return $login;
        } else {
            return response()->json([
                'msg' => 'User unknown'
            ], 400);
        };
    }

    private function findActivation($r)
    {
        $activation = Activation::where('code', $r->phone.$r->activation_code)->first();
        if (count($activation) == 0) {
            return false;
        } else {
            return true;
        }
    }

    private function activateUser($r)
    {
        $activation = Activation::where('code', $r->phone.$r->activation_code)->first();
        $activation->update([
            'completed' => 1,
            'completed_at' => Carbon::now()
        ]);

        if ($activation) {
            $user = User::find($activation->user_id);
            $user->is_active = 1;
            $user->save();
        } else {
            return response()->json([
                'msg' => 'Activation failed'
            ], 401);
        }
    }

    private function logUserIn($r)
    {
        $params = $this->getParams($r);
        $r->request->add($params);
        $proxy = Request::create('api/login', 'POST');
        $credentials = [
            'phone' => $r->phone,
            'password' => $r->password,
            'is_active' => 1
        ];
        if (Auth::attempt($credentials)) {
            return Route::dispatch($proxy);
        } else {
            return response()->json([
              'msg' => 'Login failed'
            ], 401);
        }
    }
}
