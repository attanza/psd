<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReseller;
use App\Http\Resources\Store\StoreR;
use App\Http\Resources\Store\StoreRCollection;
use App\Models\Reseller;

class OutletController extends Controller
{
    public function index()
    {
        return view('outlets.index');
    }

    public function getOutletList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
            'storeId' =>'nullable|integer'
        ]);

        $searchQ = $request->input('searchQ');
        $storeId = $request->input('storeId');
        if ($searchQ != null || $searchQ != '') {
            $stores = Reseller::Where('name', 'LIKE', "%$searchQ%")
                ->orWhere('code', 'LIKE', "%$searchQ%")
                ->orWhere('pic', 'LIKE', "%$searchQ%")
                ->orWhere('email', 'LIKE', "%$searchQ%")
                ->where('parent_id', 0)
                ->orderBy('name')->paginate($request->paginate);
        } elseif ($storeId != null || $storeId != '') {
            $stores = Reseller::where('parent_id', $storeId)
                ->orderBy('name')->paginate($request->paginate);
        } else {
            $stores = Reseller::where('parent_id', '<>', 0)->orderBy('name')->paginate($request->paginate);
        }
        return new StoreRCollection($stores);
    }

    public function store(StoreReseller $request)
    {
        $outlet = Reseller::create($request->all());
        return new StoreR($outlet);
    }

    public function update(StoreReseller $request, $id)
    {
        $outlet = Reseller::find($id);
        $outlet->update($request->all());
        return new StoreR($outlet);
    }

    public function saveLocation(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
        $outlet = Reseller::find($id);
        $outlet->lat = $request->lat;
        $outlet->lng = $request->lng;
        $outlet->save();
        return new StoreR($outlet);
    }

    public function show($id)
    {
        $outlet = Reseller::find($id);
        if (count($outlet) == 0) {
            return response('/outlets')->withError('Outlet not found');
        }
        $data = new StoreR($outlet);
        return view('outlets.show')->withOutlet(collect($data));
    }
}
