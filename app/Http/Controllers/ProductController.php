<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productService->index($request);
        return ProductResource::collection($products);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        if (!empty($request->image)) {
            $product->image = Helper::fileUpload($request->image);
        }
        $request->offsetUnset('image');
        $product->fill($request->all());
        $product->save();
        return $this->returnResponse('success', 'Product created successfully', $product, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = [
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $product->image,
        ];
        if ($request->filled('image')) {
            if (Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $data['image'] = Helper::fileUpload($request->image);
        }
        $product->update($data);
        return $this->returnResponse("success", "Product Updated successfully", $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Storage::disk('public')->exists('products/' . $product->image)) {
            Storage::disk('public')->delete('products/' . $product->image);
        }
        $product->delete();
        return $this->returnResponse("success", "Product Deleted successfully");
    }
}