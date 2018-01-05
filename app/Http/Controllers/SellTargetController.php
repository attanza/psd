<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SellTarget\SellTargetR;
use App\Http\Resources\SellTarget\SellTargetRCollection;
use App\Models\SellTarget;
use App\Models\Product;
use App\Models\Area;
use App\Http\Requests\StoreTarget;

class SellTargetController extends Controller
{
    public function index()
    {
        return view('sell_targets.index')->with([
            'products' => $this->getProducts(),
            'areas' => $this->getAreas()
        ]);
    }

    public function getTargetList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
        ]);

        $searchQ = $request->input('searchQ');
        if ($searchQ != null || $searchQ != '') {
            $targets = SellTarget::orWhere('name', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } else {
            $targets = SellTarget::orderBy('name')->paginate($request->paginate);
        }
        return new SellTargetRCollection($targets);
    }

    public function store(StoreTarget $request)
    {
        $sellTarget = SellTarget::create($request->all());
        return new SellTargetR($sellTarget);
    }

    private function getProducts()
    {
        return Product::select('id', 'name')->orderBy('name')->get();
    }

    private function getAreas()
    {
        return Area::select('id', 'name')->orderBy('name')->get();
    }
}
