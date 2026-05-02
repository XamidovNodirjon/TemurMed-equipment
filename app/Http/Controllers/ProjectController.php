<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_active', true)
            ->latest('published_at')
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function show($locale, $slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $project->increment('views_count');

        return view('projects.show', compact('project'));
    }
}
