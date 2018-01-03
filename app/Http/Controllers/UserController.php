<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User\UserR;
use App\Http\Resources\User\UserRCollection;
use App\Mail\ResetPasswordMail;
use Mail;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function getUserList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
        ]);

        $searchQ = $request->input('searchQ');
        if ($searchQ != null || $searchQ != '') {
            $users = User::orWhere('name', 'LIKE', "%$searchQ%")
                ->orWhere('email', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } else {
            $users = User::orderBy('name')->paginate($request->paginate);
        }
        return new UserRCollection($users);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:150|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserR($user);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show')->withUser($user);
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $hash = str_random(6);
        $user->update([
            'password' => bcrypt($hash)
        ]);
        Mail::to($user->email)->send(new ResetPasswordMail($user, $hash));
        $msg = 'A temporary password has been sent to '. $user->email;
        return response()->json(['msg' => $msg], 200);
    }
}
