<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        $products = \App\Models\Product::where('is_active', true)->paginate(12);

        return view('catalog.index', compact('categories', 'products'));
    }

    public function show($locale, $slug)
    {
        $product = \App\Models\Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    public function category($locale, $slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $categories = \App\Models\Category::where('is_active', true)->get();
        
        $products = \App\Models\Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);

        return view('catalog.index', compact('categories', 'products', 'category'));
    }
}
