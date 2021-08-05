<div class="card grid gap-2 mt-6">
    @foreach($activities as $activity)
        <div class="text-sm flex items-center justify-between">
            @includeIf("projects.activities.{$activity->description}")
            <p class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</p>
        </div>
    @endforeach
</div>
