<form
    method="POST"
    action="{{ $endpoint }}"
    class="form"
>
    @csrf
    @method($method)

    <h2 class="text-2xl mb-10 text-center">
        {{ $heading }}
    </h2>

    <div class="mb-6">
        <label for="title" class="label tex-sm mb-2 block">Title</label>

        <input
            type="text" name="title" id="title" placeholder="My next awesome project"
            class="input w-full" value="{{ $title }}" required>
    </div>

    <div class="mb-6">
        <label for="description" class="label tex-sm mb-2 block">Description</label>

        <textarea
            name="description" id="description" placeholder="Add some description..."
            class="input w-full" style="min-height: 100px; max-height: 100px;" required>{{ $description }}</textarea>
    </div>

    <div class="">
        <button class="button mr-4" type="submit">Save</button>
        <a href="{{ $cancel_url }}">Cancel</a>
    </div>

    @include('includes.errors', ['bag' => 'projects'])
</form>
