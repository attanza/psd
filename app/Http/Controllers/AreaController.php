<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Http\Resources\Area\AreaR;
use App\Http\Resources\Area\AreaRCollection;


class AreaController extends Controller
{
    public function index()
    {
        return view('areas.index');
    }

    public function getAreaList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
        ]);

        $searchQ = $request->input('searchQ');
        $categoryId = $request->input('categoryId');
        if ($searchQ != null || $searchQ != '') {
            $areas = Area::orWhere('name', 'LIKE', "%$searchQ%")
                ->orWhere('description', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } else {
            $areas = Area::orderBy('name')->paginate($request->paginate);
        }
        return new AreaRCollection($areas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150|unique:areas',
            'description' => 'nullable|string|max:200'
        ]);

        $area = Area::create($request->all());
        return new AreaR($area);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:150|unique:areas,name,'.$id,
            'description' => 'nullable|string|max:200'
        ]);

        $area = Area::find($id);
        $area->update($request->all());
        return new AreaR($area);
    }
}
