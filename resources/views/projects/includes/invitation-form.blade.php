<div class="card mt-6">
    <h3 class="-ml-5 text-xl mb-3 pl-4 pr-5 py-2 border-l-4 border-blue-300">
        Invite A User
    </h3>

    <form action="{{ $project->path() . '/invitations' }}" method="POST">
        @csrf

        <div class="mt-3 flex">
            <input class="input w-full mr-3" type="text" name="email" placeholder="Email">
            <button type="submit" class="button">Invite</button>
        </div>


        @include('includes.errors', ['bag' => 'invitations'])
    </form>
</div>
