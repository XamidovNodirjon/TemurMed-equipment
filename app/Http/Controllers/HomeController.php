<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = \App\Models\Slider::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $recommendedProducts = \App\Models\Product::where('is_active', true)
            ->where('is_recommended', true)
            ->latest()
            ->take(8)
            ->get();

        $latestNews = \App\Models\News::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('recommendedProducts', 'sliders', 'latestNews'));
    }
}
