<nav x-data="{ open: false }" class=" bg-darkGrey border-gray-100">
    <!-- Navigation Menu -->
    <div class="flex h-nav justify-between items-center">

        <!-- Logo -->
        <div class="w-[225px] flex items-center ml-[16px]">
            <a class="titre" href="{{ route('decouverte') }}">
                Terracium
            </a>
        </div>

        <!-- Barre de recherche -->
        <div>
            <form action="" class="w-[500px] h-[38px] py-auto"> {{-- Il faut remplir l'action --}}
                <input class="w-full rounded h-full" type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Boutons de droite -->
        <div class="flex justify-end w-[225px] items-center">

            {{-- Bouton panier --}}
            <div class="ml-[15px]">
                <svg width="34" height="34" viewBox="0 0 48 48" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 2H10L15.36 28.78C15.5429 29.7008 16.0438 30.5279 16.7751 31.1166C17.5064 31.7053 18.4214 32.018 19.36 32H38.8C39.7386 32.018 40.6536 31.7053 41.3849 31.1166C42.1162 30.5279 42.6171 29.7008 42.8 28.78L46 12H12M20 42C20 43.1046 19.1046 44 18 44C16.8954 44 16 43.1046 16 42C16 40.8954 16.8954 40 18 40C19.1046 40 20 40.8954 20 42ZM42 42C42 43.1046 41.1046 44 40 44C38.8954 44 38 43.1046 38 42C38 40.8954 38.8954 40 40 40C41.1046 40 42 40.8954 42 42Z"
                        stroke="#F4F0EC" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            {{-- Bouton notification --}}
            <div class="border border-red ml-[15px]">
                <svg width="34" height="34" viewBox="0 0 48 48" fill="none" class="flex item-center"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M27.46 42C27.1084 42.6062 26.6037 43.1093 25.9965 43.4591C25.3892 43.8088 24.7008 43.9929 24 43.9929C23.2992 43.9929 22.6108 43.8088 22.0035 43.4591C21.3963 43.1093 20.8916 42.6062 20.54 42M36 16C36 12.8174 34.7357 9.76516 32.4853 7.51472C30.2348 5.26428 27.1826 4 24 4C20.8174 4 17.7652 5.26428 15.5147 7.51472C13.2643 9.76516 12 12.8174 12 16C12 30 6 34 6 34H42C42 34 36 30 36 16Z"
                        stroke="#F4F0EC" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            {{-- Bouton profil --}}
            <div class="hidden sm:flex sm:items-center ml-[15px] mr-[16px]">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex item-center">
                            <svg width="24" height="34" viewBox="0 0 34 44" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 36.2857V39.1429C2 39.9006 2.31607 40.6273 2.87868 41.1632C3.44129 41.699 4.20435 42 5 42H29C29.7956 42 30.5587 41.699 31.1213 41.1632C31.6839 40.6273 32 39.9006 32 39.1429V36.2857C32 34.0124 31.0518 31.8323 29.364 30.2248C27.6761 28.6173 25.3869 27.7143 23 27.7143H11C8.61305 27.7143 6.32387 28.6173 4.63604 30.2248C2.94821 31.8323 2 34.0124 2 36.2857ZM26 10.5714C26 12.8447 25.0518 15.0249 23.364 16.6323C21.6761 18.2398 19.3869 19.1429 17 19.1429C14.6131 19.1429 12.3239 18.2398 10.636 16.6323C8.94821 15.0249 8 12.8447 8 10.5714C8 8.29814 8.94821 6.11797 10.636 4.51051C12.3239 2.90306 14.6131 2 17 2C19.3869 2 21.6761 2.90306 23.364 4.51051C25.0518 6.11797 26 8.29814 26 10.5714Z"
                                    stroke="#F4F0EC" stroke-width="4" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>

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
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

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
