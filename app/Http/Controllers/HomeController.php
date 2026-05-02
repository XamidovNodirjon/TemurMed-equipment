<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = collect();
        try {
            $sliders = \App\Models\Slider::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get();
        } catch (\Exception $e) {
        }

        $recommendedProducts = collect();
        try {
            $recommendedProducts = \App\Models\Product::where('is_active', true)
                ->where('is_recommended', true)
                ->latest()
                ->take(8)
                ->get();
        } catch (\Exception $e) {
        }

        $latestNews = collect();
        try {
            $latestNews = \App\Models\News::where('is_active', true)
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        } catch (\Exception $e) {
        }

        $latestProjects = collect();
        try {
            $latestProjects = \App\Models\Project::where('is_active', true)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        } catch (\Exception $e) {
        }

        return view('home', compact('recommendedProducts', 'sliders', 'latestNews', 'latestProjects'));
    }
}
