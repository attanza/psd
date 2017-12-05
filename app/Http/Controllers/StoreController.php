<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReseller;
use App\Http\Resources\Store\StoreR;
use App\Http\Resources\Store\StoreRCollection;
use App\Models\Reseller;

class StoreController extends Controller
{
    public function index()
    {
        return view('stores.index');
    }

    public function getStoreList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
            'marketId' =>'nullable|integer'
        ]);

        $searchQ = $request->input('searchQ');
        $marketId = $request->input('marketId');
        if ($searchQ != null || $searchQ != '') {
            $stores = Reseller::Where('name', 'LIKE', "%$searchQ%")
                ->orWhere('code', 'LIKE', "%$searchQ%")
                ->orWhere('pic', 'LIKE', "%$searchQ%")
                ->orWhere('email', 'LIKE', "%$searchQ%")
                ->where('parent_id', 0)
                ->orderBy('name')->paginate($request->paginate);
        } elseif ($marketId != null || $marketId != '') {
            $stores = Reseller::whereHas('market', function ($query) use ($marketId) {
                $query->where('market_id', $marketId);
            })->orderBy('name')->paginate($request->paginate);
        } else {
            $stores = Reseller::where('parent_id', 0)->orderBy('name')->paginate($request->paginate);
        }
        return new StoreRCollection($stores);
    }

    public function store(StoreReseller $request)
    {
        $store = Reseller::create($request->all());
        return new StoreR($store);
    }

    public function update(StoreReseller $request, $id)
    {
        $store = Reseller::find($id);
        $store->update($request->all());
        return new StoreR($store);
    }

    public function saveLocation(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
        $store = Reseller::find($id);
        $store->lat = $request->lat;
        $store->lng = $request->lng;
        $store->save();
        return new StoreR($store);
    }

    public function show($id)
    {
        $store = Reseller::find($id);
        if (count($store) == 0) {
            return response('/stores')->withError('Store not found');
        }
        $data = new StoreR($store);
        return view('stores.show')->withStore(collect($data));
    }
}
