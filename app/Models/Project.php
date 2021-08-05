<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    use HasFactory, RecordsActivity;

    protected static $recordableEvents = ['created', 'updated'];

    protected $guarded = [];

//    Relationships

    public function owner ()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks ()
    {
        return $this->hasMany(Task::class);
    }

    public function activities ()
    {
        return $this->hasMany(Activity::class);
    }

    public function members ()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

//    Methods

    public function path (string $route = '') : string
    {
        return route('projects.show', $this->id) . $route;
    }

    public function addTask (string $body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function addTasks (array $tasks)
    {
        return $this->tasks()->createMany($tasks);
    }

    public function invite (User $user)
    {
        $this->members()->attach($user);
        return $this;
    }
}
