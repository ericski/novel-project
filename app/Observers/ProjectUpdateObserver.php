<?php

namespace App\Observers;

use App\Models\ProjectUpdate;

class ProjectUpdateObserver
{
    /**
     * Handle the ProjectUpdate "created" event.
     */
    public function created(ProjectUpdate $projectUpdate): void
    {
        $this->updateProjectPercentComplete($projectUpdate);
    }

    /**
     * Handle the ProjectUpdate "updated" event.
     */
    public function updated(ProjectUpdate $projectUpdate): void
    {
        $this->updateProjectPercentComplete($projectUpdate);
    }

    /**
     * Handle the ProjectUpdate "deleted" event.
     */
    public function deleted(ProjectUpdate $projectUpdate): void
    {
        $this->updateProjectPercentComplete($projectUpdate);
    }

    /**
     * Handle the ProjectUpdate "restored" event.
     */
    public function restored(ProjectUpdate $projectUpdate): void
    {
        $this->updateProjectPercentComplete($projectUpdate);
    }

    /**
     * Update the project's percent_complete field.
     */
    protected function updateProjectPercentComplete(ProjectUpdate $projectUpdate): void
    {
        $project = $projectUpdate->project;

        // Calculate the total count from all updates
        $totalCount = $project->updates()->sum('count');

        // Calculate percent complete
        $percentComplete = $project->goal > 0
            ? ($totalCount / $project->goal) * 100
            : 0;

        // Update the project without triggering events
        $project->updateQuietly(['percent_complete' => $percentComplete]);
    }
}
