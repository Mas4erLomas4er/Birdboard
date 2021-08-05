<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function store (Project $project, InvitationRequest $request)
    {
        $user = User::where('email', request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
