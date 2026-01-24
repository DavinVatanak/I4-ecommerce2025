<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only(['name', 'description', 'price', 'category_id']));
        return response()->json($product, 201);
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return response()->json($product);
    }

    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $product->update($request->only(['name', 'description', 'price', 'category_id']));
        return response()->json($product);
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
