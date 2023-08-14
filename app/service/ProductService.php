<?php

namespace App\service;

use App\Helper\Helper;
use App\Models\Product;

class ProductService
{
    /**
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($request)
    {
        $query = Product::query();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        return $query->orderBy('id', 'desc')->paginate($request->per_page);
    }

    public function store($request)
    {

        $product = new Product();
        if (!empty($request->image)) {
            $product->image = Helper::fileUpload($request->image);
        }
        $request->offsetUnset('image');
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        if (!is_null($product)) {
            $product->stock()->create([
                'product_id' => $product->id,
                'quantity' => $request->stock
            ]);
        }

        $product ? $product : null;

    }

    public function allProduct()
    {
        return Product::query()->latest()->get();

    }
}
