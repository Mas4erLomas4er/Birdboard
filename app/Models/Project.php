<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path () : string
    {
        return route('projects.show', $this->id);
    }

    public function owner ()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks ()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask (string $body)
    {
        return $this->tasks()->create(compact('body'));
    }
}
