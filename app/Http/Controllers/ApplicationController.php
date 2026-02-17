<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'locale' => 'required|string|in:uz,ru,en',
        ]);

        Application::create($validated);

        return redirect()->back()->with('success', __('application.submitted_successfully'));
    }
}
