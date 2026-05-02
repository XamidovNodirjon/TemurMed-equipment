<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = \App\Models\News::where('is_active', true)
            ->latest('published_at')
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show($locale, $slug)
    {
        $news = \App\Models\News::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $news->increment('views_count');

        return view('news.show', compact('news'));
    }
}
