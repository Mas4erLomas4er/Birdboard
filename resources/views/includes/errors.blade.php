@if ($errors->{ $bag ?? 'default' }->any())
    <div class="mt-6 bg-red-200 p-3 rounded-lg grid gap-3">
        @foreach($errors->{ $bag ?? 'default' }->all() as $error)
            <p class="text-sm">{{ $error }}</p>
        @endforeach
    </div>
@endif
