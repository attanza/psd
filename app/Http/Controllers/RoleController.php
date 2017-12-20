<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Http\Resources\Role\RoleR;
use App\Http\Resources\Role\RoleRCollection;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }

    public function getRoleList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
        ]);

        $searchQ = $request->input('searchQ');
        if ($searchQ != null || $searchQ != '') {
            $roles = Role::orWhere('name', 'LIKE', "%$searchQ%")
                ->orWhere('description', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } else {
            $roles = Role::orderBy('name')->paginate($request->paginate);
        }
        return new RoleRCollection($roles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150|unique:roles',
            'display_name' => 'required|max:150|unique:roles',
            'description' => 'nullable|string|max:200'
        ]);

        $role = Role::create($request->all());
        return new RoleR($role);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:150|unique:roles,name,'.$id,
            'display_name' => 'required|max:150|unique:roles,display_name,'.$id,
            'description' => 'nullable|string|max:200'
        ]);

        $role = Role::find($id);
        $role->update($request->all());
        return new RoleR($role);
    }
}
