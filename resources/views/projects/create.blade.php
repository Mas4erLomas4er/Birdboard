@extends('layouts.app')

@section('content')
    <form method="POST" action="/projects">
        <h1 class="heading is-1">Create a Project</h1>

        @csrf

        <div class="field">
            <label for="title" class="label">Title</label>

            <div class="control">
                <input type="text" name="title" id="title" class="input" placeholder="Title">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>

            <div class="control">
                <textarea name="description" id="description" class="textarea" placeholder="Description"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is_link" type="submit">Create Project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
@endsection
