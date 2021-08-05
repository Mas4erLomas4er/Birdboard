<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User user
 */
class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'changes' => 'array',
    ];

//    Relationships

    public function subject ()
    {
        return $this->morphTo();
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

//    Methods

    public function getUserName ()
    {
        return auth()->user()->is($this->user) ? 'You' : $this->user->name;
    }
}
