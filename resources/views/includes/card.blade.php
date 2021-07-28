<div class="card h-48">
    <h3>
        <a class="text-xl -ml-5 pl-4 pr-5 py-3 border-l-4 border-blue-300 mb-4 inline-block" href="{{ $project->path() }}">
            {{ $project->title }}
        </a>
    </h3>

    <div class="text-gray-400">
        {{ \Illuminate\Support\Str::limit($project->description, 150) }}
    </div>
</div>
