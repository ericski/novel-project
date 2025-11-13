<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Project;
use App\Rules\NoBannedWords;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        // Get sort parameters
        $sortBy = request()->input('sort', 'created_at');
        $sortDirection = request()->input('direction', 'asc');

        // Validate sort parameters
        $allowedSorts = ['created_at', 'percent_complete'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        // Build the base query
        $query = Project::mine();

        // Apply sorting - if sorting by percent_complete, only sort by that
        // Otherwise, sort by active first, then by the selected field
        if ($sortBy === 'percent_complete') {
            $query->orderBy('percent_complete', $sortDirection);
        } else {
            $query->orderByDesc('active')->orderBy($sortBy, $sortDirection);
        }

        $projects = $query->paginate(25)->withQueryString();
        $active = 'Mine';

        // Check if the url contains "all" then return all projects instead
        if (request()->has('all')) {
            $query = Project::query();

            if ($sortBy === 'percent_complete') {
                $query->orderBy('percent_complete', $sortDirection);
            } else {
                $query->orderByDesc('active')->orderBy($sortBy, $sortDirection);
            }

            $projects = $query->paginate(25)->withQueryString();
            $active = 'All';
        }

        // Check if the url contains "friends" then return all projects from friends instead
        if (request()->has('friends')) {
            $query = Project::friends();

            if ($sortBy === 'percent_complete') {
                $query->orderBy('percent_complete', $sortDirection);
            } else {
                $query->orderByDesc('active')->orderBy($sortBy, $sortDirection);
            }

            $projects = $query->paginate(25)->withQueryString();
            $active = 'Friends';
        }

        return view('projects.index', [
            'projects' => $projects,
            'active' => $active,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function show(Project $project)
    {
        $event = Event::where('is_active', true)->first();
        return view('projects.show', [
            'project' => $project,
            'activeEvent' => $event->id ?? null,
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => ['required', 'string', 'max:255', new NoBannedWords],
            'description' => 'required',
            'goal' => 'required|numeric',
            'goal_type' => 'required|boolean',
            'cover' => 'image',
        ]);

        // Store the image
        if (request('cover')) {
            $path = request('cover')->store('covers', 'public');
            $attributes['cover'] = Storage::url($path);
        }

        Project::create($attributes + ['author_id' => auth()->id()]);

        return redirect('/projects');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    public function update(Project $project)
    {
        $attributes = request()->validate([
            'title' => ['required', 'string', 'max:255', new NoBannedWords],
            'description' => 'required',
            'goal' => 'required|numeric',
            'goal_type' => 'required|boolean',
            'cover' => 'image',
            'active' => 'required|boolean',
            'status' => 'required|in:pending,in progress,shelved,abandoned,complete',
        ]);

        // Store the image
        if (request('cover')) {
            $path = request('cover')->store('covers', 'public');
            $attributes['cover'] = Storage::url($path);
        }

        $project->update($attributes);

        return redirect('projects/' . $project->slug);
    }
}
