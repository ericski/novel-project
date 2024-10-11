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

        $projects = Project::mine()->orderByDesc('active')->orderBy('created_at')->paginate(25)->withQueryString();
        $active = 'Mine';

        // Check if the url contains "all" then return all projects instead
        if (request()->has('all')) {
            $projects = Project::orderByDesc('active')->orderBy('created_at')->paginate(25)->withQueryString();
            $active = 'All';
        }

        // Check if the url contains "friends" then return all projects from friends instead
        if (request()->has('friends')) {
            $projects = Project::friends()->orderByDesc('active')->orderBy('created_at')->paginate(25)->withQueryString();
            $active = 'Friends';
        }

        return view('projects.index', [
            'projects' => $projects,
            'active' => $active,
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
