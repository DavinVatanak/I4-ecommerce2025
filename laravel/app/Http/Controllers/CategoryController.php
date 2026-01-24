<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $category = Category::create($request->only(['name', 'description']));
        return response()->json($category, 201);
    }

    public function show($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return response()->json($category);
    }

    public function update(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update($request->only(['name', 'description']));
        return response()->json($category);
    }

    public function destroy($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }

    public function products($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json($products);
    }
}
