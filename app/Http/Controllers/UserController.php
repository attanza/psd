<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User\UserR;
use App\Http\Resources\User\UserRCollection;

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
}
