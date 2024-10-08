<nav x-data="{ open: false }" class="z-50 h-[48px] fixed w-full bg-darkGrey border-gray-100">
    <!-- Navigation Menu -->
    <div class="flex h-nav justify-between items-center">

        <!-- Logo -->
        <div class="w-[225px] flex items-center ml-[16px]">
            <a class="navTitre" href="{{ route('decouverte') }}">
                @Terracium
            </a>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('decouverte')" :active="request()->routeIs('decouverte')">
                    {{ __('decouverte') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
</nav>
