@extends('layouts.app')

@section('content')
    <header class="flex items-center justify-between py-6 ml-2">
        <div class="">
            <h2 class="text-muted text-sm">
                <a class="hover:underline" href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </h2>
        </div>
        <div class="flex items-center">
            <div class="flex mr-4">
                <img
                    class="rounded-full mr-2 w-8"
                    src="{{ gravatar_url($project->owner->email) }}"
                    alt="{{ $project->owner->name }}" title="{{ $project->owner->name }}">

                @foreach($project->members as $member)
                    <img
                        class="rounded-full mr-2 w-8"
                        src="{{ gravatar_url($member->email) }}"
                        alt="{{ $member->name }}" title="{{ $member->name }}">
                @endforeach
            </div>
            <a class="button" href="{{ route("projects.edit", $project->id) }}">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="flex flex-col-reverse lg:flex-row">
            <div class="lg:w-2/3 lg:pr-6">
                <div class="mb-8">
                    <h3 class="text-muted text-lg mb-2 ml-2">Tasks</h3>

                    <div class="grid gap-6">
                        @foreach($project->tasks as $task)
                            <div class="card">
                                <form action="{{ $task->path() }}" method="POST" autocomplete="off">
                                    @method('PATCH')
                                    @csrf

                                    <div class="flex items-center">
                                        <input class="w-full bg-transparent outline-none {{ $task->completed ? 'text-muted line-through' : '' }}"
                                               value="{{ $task->body }}" autocomplete="off"
                                               type="text" name="body" id="update-task-body">
                                        <input class="" {{ $task->completed ? 'checked' : ''}} onchange="this.form.submit()"
                                               type="checkbox" name="completed" id="update-task-completed">
                                    </div>

                                </form>
                            </div>
                        @endforeach
                        <div class="card">
                            <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}" autocomplete="off">
                                @csrf
                                <input class="w-full bg-transparent outline-none" type="text" name="body"
                                       id="create-task-body" placeholder="Add a new task..." autocomplete="off">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="">
                    <h3 class="text-muted text-lg mb-2 ml-2">General Notes</h3>

                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="title" value="{{ $project->title }}">
                        <input type="hidden" name="description" value="{{ $project->description }}">

                        <textarea
                            name="notes"
                            class="card w-full mb-4 outline-none"
                            placeholder="Write some notes here..."
                            style="min-height: 200px; max-height: 700px;"
                        >{{ $project->notes }}</textarea>

                        <button class="button" type="submit">Save</button>

                        @include('includes.errors', ['bag' => 'projects'])
                    </form>
                </div>
            </div>
            <div class="lg:w-1/3 mb-6 lg:mb-0 mt-9">
                @include('projects.includes.card')
                @can('invite', $project)
                    @include('projects.includes.invitation-form')
                @endcan
                @include('projects.includes.activity', compact('activities'))
            </div>
        </div>
    </main>
@endsection
