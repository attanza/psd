<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Resources\User\UserR;

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
}
