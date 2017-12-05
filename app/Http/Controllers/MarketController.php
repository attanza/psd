<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMarket;
use App\Models\Area;
use App\Models\Market;
use App\Http\Resources\Market\MarketR;
use App\Http\Resources\Market\MarketRCollection;

class MarketController extends Controller
{
    public function index()
    {
        return view('markets.index');
    }

    public function getMarketList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
            'areaId' =>'nullable|integer'
        ]);

        $searchQ = $request->input('searchQ');
        $areaId = $request->input('areaId');
        if ($searchQ != null || $searchQ != '') {
            $markets = Market::Where('name', 'LIKE', "%$searchQ%")
                ->orWhere('address', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } elseif ($areaId != null || $areaId != '') {
            $markets = Market::whereHas('area', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            })->orderBy('name')->paginate($request->paginate);
        } else {
            $markets = Market::orderBy('name')->paginate($request->paginate);
        }
        return new MarketRCollection($markets);
    }

    public function store(StoreMarket $request)
    {
        $market = Market::create($request->all());
        return new MarketR($market);
    }

    public function update(StoreMarket $request, $id)
    {
        $market = Market::find($id);
        $market->update($request->all());
        return new MarketR($market);
    }

    public function saveLocation(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
        $market = Market::find($id);
        $market->lat = $request->lat;
        $market->lng = $request->lng;
        $market->save();
        return new MarketR($market);
    }

    public function show($id)
    {
        $market = Market::find($id);
        if (count($market) == 0) {
            return response('/markets')->withError('Market not found');
        }
        $data = new MarketR($market);
        return view('markets.show')->withMarket(collect($data))->withAreas($this->getAreas());
    }

    private function getAreas()
    {
        $areas = Area::select('id', 'name')->orderBy('name')->get();
        return $areas;
    }

    public function getMarketForCombo()
    {
        $markets = Market::select('id', 'name')->orderBy('name')->get();
        return response()->json($markets, 200);
    }

    public function getMarketByAreaId($areaId)
    {
        $markets = Market::select('id', 'name')
        ->where('area_id', $areaId)
        ->orderBy('name')->get();
        return response()->json($markets, 200);
    }
}
