<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @property int project_id
 */
class Task extends Model
{
    use HasFactory, RecordsActivity;

    protected static $recordableEvents = ['created', 'deleted'];

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean',
    ];

//    Relationships

    public function project ()
    {
        return $this->belongsTo(Project::class);
    }

    public function activities ()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

//    Methods
    public function path () : string
    {
        return route('projects.tasks.update', [$this->project->id, $this->id]);
    }

    public function complete ()
    {
        if ($this->completed) return $this;

        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');

        return $this->refresh();
    }

    public function incomplete ()
    {
        if (!$this->completed) return $this;

        $this->update(['completed' => false]);

        $this->recordActivity('uncompleted_task');

        return $this->refresh();
    }
}
