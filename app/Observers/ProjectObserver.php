<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Arr;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param Project $project
     * @return void
     */
    public function created (Project $project)
    {
        $project->recordActivity('created_project');
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param Project $project
     * @return void
     */
    public function updated (Project $project)
    {
        $project->recordActivity('updated_project');
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param Project $project
     * @return void
     */
    public function deleted (Project $project)
    {
        //
    }
}
