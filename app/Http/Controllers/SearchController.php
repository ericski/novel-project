<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $active = 'Users';

        // Initialize empty collections
        $users = User::query()->where('id', 0)->paginate(25);
        $projects = Project::query()->where('id', 0)->paginate(25);

        if ($query) {
            $users = User::where('name', 'like', "%{$query}%")
                ->paginate(25)
                ->withQueryString();

            $projects = Project::where('title', 'like', "%{$query}%")
                ->paginate(25)
                ->withQueryString();
        }

        // Check which tab is active
        if ($request->has('projects')) {
            $active = 'Projects';
        }

        return view('search.index', [
            'users' => $users,
            'projects' => $projects,
            'query' => $query,
            'active' => $active,
        ]);
    }
}
