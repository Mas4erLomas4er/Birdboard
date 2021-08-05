@extends('layouts.app')

@section('content')
    @include('projects.includes.form', [
        'title' => $project->title,
        'description' => $project->description,
        'endpoint' => route('projects.update', $project->id),
        'method' => 'PATCH',
        'heading' => 'Edit Your Project',
        'cancel_url' => $project->path(),
    ])
@endsection
