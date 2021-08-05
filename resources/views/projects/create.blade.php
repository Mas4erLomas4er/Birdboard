@extends('layouts.app')

@section('content')
    @include('projects.includes.form', [
        'title' => '',
        'description' => '',
        'endpoint' => route('projects.store'),
        'method' => 'POST',
        'heading' => 'Let\' Start Something New',
        'button_text' => 'Create Project',
        'cancel_url' => route('projects.index'),
    ])
@endsection
