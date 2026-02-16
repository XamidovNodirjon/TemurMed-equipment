<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('is_active', true)->with('subCategories')->get();
        $products = \App\Models\Product::where('is_active', true)->paginate(12);

        return view('catalog.index', compact('categories', 'products'));
    }

    public function show($locale, $slug)
    {
        $product = \App\Models\Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = \App\Models\Product::where('sub_category_id', $product->sub_category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    public function category($locale, $slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $categories = \App\Models\Category::where('is_active', true)->with('subCategories')->get();
        
        // Get products via subcategories
        $subCategoryIds = $category->subCategories->pluck('id');
        $products = \App\Models\Product::whereIn('sub_category_id', $subCategoryIds)
            ->where('is_active', true)
            ->paginate(12);

        return view('catalog.index', compact('categories', 'products', 'category'));
    }
}
