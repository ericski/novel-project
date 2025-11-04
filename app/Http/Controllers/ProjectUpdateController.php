<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectUpdateController extends Controller
{
    //
    public function index(Project $project)
    {
        $updates = $project->latestUpdates()->get();
        return view('projects.history', [
            'project' => $project,
            'updates' => $updates,
        ]);

    }
}
