<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        // If the goal was changed, recalculate percent_complete
        if ($project->isDirty('goal')) {
            $totalCount = $project->updates()->sum('count');
            $percentComplete = $project->goal > 0
                ? ($totalCount / $project->goal) * 100
                : 0;

            // Update without triggering events again
            $project->updateQuietly(['percent_complete' => $percentComplete]);
        }
    }
}
