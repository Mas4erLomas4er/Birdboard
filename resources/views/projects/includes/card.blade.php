<div class="card h-52 flex flex-col">
    <h3 class="-ml-5 text-xl mb-3">
        <a class="pl-4 pr-5 py-2 border-l-4 border-accent inline-block" href="{{ $project->path() }}">
            {{ $project->title }}
        </a>
    </h3>

    <div class="text-gray-400 mb-4 break-words flex-1">
        {{ \Illuminate\Support\Str::limit($project->description, 100) }}
    </div>

    <div class="flex justify-end items-center">
        <a class="text-sm text-muted-light hover:text-muted transition duration-200"
           href="{{ route('projects.edit', $project) }}">Edit</a>
        @can('delete', $project)
            <form action="{{ $project->path() }}" method="POST" class="ml-3 block border-0" style="margin-top: -1px;">
                @csrf
                @method('DELETE')
                <button class="text-sm text-muted-light hover:text-muted transition duration-200"
                        type="submit">Delete
                </button>
            </form>
        @endcan
    </div>

</div>
