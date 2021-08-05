<nav class="bg-header">
    <div class="container mx-auto">
        <div class="flex justify-between items-center py-2">
            <h1>
                <a class="" href="{{ route("projects.index") }}">
                    @include('svg.logo')
                </a>
            </h1>
            <div class="flex items-center">
                <theme-switcher></theme-switcher>
                @guest
                    <a class="mr-3" href="{{ route('login') }}">Login</a>
                    <a class="" href="{{ route('register') }}">Register</a>
                @else
                    <a class="mr-4" href="#">{{ Auth::user()->name }}</a>
                    <div class="">
                        <a class="" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
