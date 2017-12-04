<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use App\Http\Resources\Product\ProductR;
use App\Http\Resources\Product\ProductRCollection;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function getProductList(Request $request)
    {
        $request->validate([
            'paginate' => 'required|integer',
            'searchQ' => 'nullable|string|max:100',
        ]);

        $searchQ = $request->input('searchQ');
        if ($searchQ != null || $searchQ != '') {
            $products = Product::orWhere('name', 'LIKE', "%$searchQ%")
                ->orWhere('code', 'LIKE', "%$searchQ%")
                ->orWhere('measurement', 'LIKE', "%$searchQ%")
                ->orWhere('price', 'LIKE', "%$searchQ%")
                ->orderBy('name')->paginate($request->paginate);
        } else {
            $products = Product::orderBy('name')->paginate($request->paginate);
        }
        
        return new ProductRCollection($products);
    }

    public function store(StoreProduct $request)
    {
        $product = Product::create($request->all());
        return new ProductR($product);
    }

    public function update(StoreProduct $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return new ProductR($product);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (count($product) == 0) {
            return response('/products')->withError('product not found');
        }
        $data = new ProductR($product);
        return view('products.show')->withproduct(collect($data));
    }
}
