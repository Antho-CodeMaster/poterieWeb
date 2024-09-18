<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a class="font-titre" href="{{ route('dashboard') }}">
                        Terracium
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Authenticated User: Show Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="ms-1">
                                    <svg width="24" height="34" viewBox="0 0 34 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 36.2857V39.1429C2 39.9006 2.31607 40.6273 2.87868 41.1632C3.44129 41.699 4.20435 42 5 42H29C29.7956 42 30.5587 41.699 31.1213 41.1632C31.6839 40.6273 32 39.9006 32 39.1429V36.2857C32 34.0124 31.0518 31.8323 29.364 30.2248C27.6761 28.6173 25.3869 27.7143 23 27.7143H11C8.61305 27.7143 6.32387 28.6173 4.63604 30.2248C2.94821 31.8323 2 34.0124 2 36.2857ZM26 10.5714C26 12.8447 25.0518 15.0249 23.364 16.6323C21.6761 18.2398 19.3869 19.1429 17 19.1429C14.6131 19.1429 12.3239 18.2398 10.636 16.6323C8.94821 15.0249 8 12.8447 8 10.5714C8 8.29814 8.94821 6.11797 10.636 4.51051C12.3239 2.90306 14.6131 2 17 2C19.3869 2 21.6761 2.90306 23.364 4.51051C25.0518 6.11797 26 8.29814 26 10.5714Z" stroke="#444444" stroke-width="3.8"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div>{{ Auth::user()->name }}</div>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Paramètres du compte') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Guest User: Show Login Modal Trigger -->
                    <div x-data="{ open: false }">
                        <!-- Include Login Modal -->
                        @include('components.login-modal')
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
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
