<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

//    Methods
    public function path () : string
    {
        return route('projects.tasks.update', [$this->project->id, $this->id]);
    }

//    Relationships

    public function project ()
    {
        return $this->belongsTo(Project::class);
    }
}
