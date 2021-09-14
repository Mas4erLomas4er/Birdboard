<nav class="bg-header">
    <div class="container mx-auto">
        <div class="flex justify-between items-center py-2">
            <h1>
                <a class="" href="{{ route("projects.index") }}">
                    @include('svg.logo')
                </a>
            </h1>
            <div class="flex items-center">
                @guest
                    <a class="mr-3" href="{{ route('login') }}">Login</a>
                    <a class="" href="{{ route('register') }}">Register</a>
                @else
                    <dropdown align="right">
                        <template v-slot:trigger>
                            <button class="mr-4">{{ Auth::user()->name }}</button>
                        </template>

                        <template v-slot:default>
                            <a href="{{ route('projects.index') }}" class="dropdown-menu-link">All My Projects</a>
                            <theme-switcher class="dropdown-menu-link"></theme-switcher>
                            <a class="dropdown-menu-link"
                               href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            >Logout</a>
                        </template>
                    </dropdown>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endguest
            </div>
        </div>
    </div>
</nav>
