@extends('layouts.app')

@section('content')
    <header class="flex items-center justify-between py-6 ml-2">
        <h2 class="text-sm text-gray-400 text-sm">My Projects</h2>
        <a class="button" href="{{ route("projects.create") }}" @click.prevent="$modal.show('new-project')">Add Project</a>
    </header>

    <main class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            @include('projects.includes.card')
        @empty
            <div class="">No projects yet</div>
        @endforelse
    </main>

    <new-project-modal></new-project-modal>
@endsection
