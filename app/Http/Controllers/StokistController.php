<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Stokist\StokistR;
use App\Http\Resources\Stokist\StokistRCollection;
use App\Http\Requests\StoreStokist;
use App\Models\Area;
use App\Models\Stokist;

class StokistController extends Controller
{
    public function index()
    {
        return view('stokists.index');
    }

    public function getStokistList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
            'areaId' =>'nullable|integer'
        ]);

        $searchQ = $request->input('searchQ');
        $areaId = $request->input('areaId');
        if ($searchQ != null || $searchQ != '') {
            $stokists = Stokist::Where('name', 'LIKE', "%$searchQ%")
                ->orWhere('code', 'LIKE', "%$searchQ%")
                ->orWhere('pic', 'LIKE', "%$searchQ%")
                ->orWhere('email', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } elseif ($areaId != null || $areaId != '') {
            $stokists = Stokist::whereHas('area', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            })->orderBy('name')->paginate($request->paginate);
        } else {
            $stokists = Stokist::orderBy('name')->paginate($request->paginate);
        }
        return new StokistRCollection($stokists);
    }

    public function store(StoreStokist $request)
    {
        $stokist = Stokist::create($request->all());
        return new StokistR($stokist);
    }

    public function update(StoreStokist $request, $id)
    {
        $stokist = Stokist::find($id);
        $stokist->update($request->all());
        return new StokistR($stokist);
    }

    public function saveLocation(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
        $stokist = Stokist::find($id);
        $stokist->lat = $request->lat;
        $stokist->lng = $request->lng;
        $stokist->save();
        return new StokistR($stokist);
    }

    public function show($id)
    {
        $stokist = Stokist::find($id);
        if (count($stokist) == 0) {
            return response('/stokists')->withError('Stokist not found');
        }
        $data = new StokistR($stokist);
        return view('stokists.show')->withStokist(collect($data))->withAreas($this->getAreas());
    }

    private function getAreas()
    {
        $areas = Area::select('id', 'name')->orderBy('name')->get();
        return $areas;
    }
}
