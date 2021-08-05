<p class="">
    {{ $activity->getUserName() }} updated the project
    @if (count($activity->changes['after']) == 1)
        {{ key($activity->changes['after'])}}
    @endif
</p>
