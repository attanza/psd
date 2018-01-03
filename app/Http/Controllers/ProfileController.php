<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Resources\User\UserR;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index')->withUser(Auth::user());
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150|unique:users,name,'.$request->id,
            'email' => 'required|email|unique:users,email,'.$request->id,
        ]);
        $user = Auth::user();
        $user->update($request->all());
        return new UserR($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed:password_confirmation',
            'password_confirmation' => 'required|min:6',

        ]);
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'msg' => 'Old Password doesnt Match'
            ], 400);
        }

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return new UserR($user);
    }
}
