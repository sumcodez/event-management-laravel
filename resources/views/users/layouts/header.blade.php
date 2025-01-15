<header>
    <div class="header-container">
        <div class="logo">
            <a href="{{ route('events.all') }}">Book My Show</a>
        </div>
        <div class="user-info">
            <span>Welcome</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </div>
    </div>
</header>
