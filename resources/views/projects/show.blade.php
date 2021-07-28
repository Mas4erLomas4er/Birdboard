@extends('layouts.app')

@section('content')
    <header class="flex items-center justify-between py-6 ml-2">
        <div class="">
            <h2 class="text-gray-400 text-sm">
                <a class="hover:underline" href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </h2>
        </div>
        <div class="">
            <a class="button" href="{{ route("projects.create") }}">Add Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex lg:flex-row-reverse">
            <div class="lg:w-1/3 mb-6 lg:mb-0 mt-9">
                @include('includes.card')
            </div>
            <div class="lg:w-2/3 lg:pr-6">
                <div class="mb-8">
                    <h3 class="text-gray-400 text-lg mb-2 ml-2">Tasks</h3>

                    <div class="grid gap-6">
                        @forelse($project->tasks as $task)
                            <div class="card">
                                <form action="{{ $task->path() }}" method="POST">
                                    @method('PATCH')
                                    @csrf

                                    <div class="flex items-center">
                                        <input class="w-full {{ $task->completed ? 'text-gray-400 line-through' : '' }}" value="{{ $task->body }}"
                                               type="text" name="body" id="update-task-body">
                                        <input class="" {{ $task->completed ? 'checked' : ''}} onchange="this.form.submit()"
                                               type="checkbox" name="completed" id="update-task-completed">
                                    </div>

                                </form>
                            </div>
                        @empty
                            <div class="card">No tasks yet.</div>
                        @endforelse
                        <div class="card">
                            <form method="POST" action="{{ route('projects.tasks.store', $project->id) }}">
                                @csrf
                                <input class="w-full" type="text" name="body" id="create-task-body" placeholder="Add a new task...">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="">
                    <h3 class="text-gray-400 text-lg mb-2 ml-2">General Notes</h3>

                    <textarea class="card w-full" style="min-height: 200px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, sapiente!</textarea>
                </div>
            </div>
        </div>
    </main>
@endsection
