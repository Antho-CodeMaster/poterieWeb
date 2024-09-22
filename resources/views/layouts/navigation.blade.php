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
        <div class="w-[500px]">
            <form action="" class="w-full h-[38px] py-auto"> {{-- Il faut remplir l'action --}}
                <input class="w-full rounded h-full" type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Boutons de droite -->
        <div class="flex justify-end w-[225px] items-center mr-[16px]">

            {{-- Bouton Admin --}}

            {{-- Bouton kiosque omg le svg est big --}}
            <svg width="34" height="34" viewBox="0 0 78 78" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect class="w-full h-full" rx="16" fill="#F4F0EC" />
                <path
                    d="M25 35C25.6137 35 26.2227 34.86 26.7897 34.5917C27.3685 34.3179 27.8848 33.9279 28.3064 33.446C28.7404 32.956 29.0834 32.3727 29.3167 31.7333C29.55 31.094 29.6667 30.408 29.6667 29.7173C29.6556 31.0799 30.1418 32.3998 31.034 33.4297C31.909 34.4143 33.0967 34.9673 34.3334 34.9673C35.57 34.9673 36.76 34.4143 37.6327 33.4297C38.525 32.3998 39.0111 31.0799 39 29.7173C38.989 31.0799 39.4751 32.3998 40.3674 33.4297C41.2424 34.4143 42.43 34.9673 43.6667 34.9673C44.9034 34.9673 46.0934 34.4143 46.966 33.4297C47.8583 32.3998 48.3444 31.0799 48.3334 29.7173C48.3334 30.4057 48.4547 31.0893 48.688 31.7263C48.9214 32.3633 49.2667 32.942 49.7007 33.4297C50.1223 33.9088 50.6377 34.2963 51.215 34.5683C51.774 34.8292 52.3833 34.9643 53 34.9643C53.6168 34.9643 54.2261 34.8292 54.785 34.5683C55.3622 34.2949 55.8781 33.9076 56.3017 33.4297C56.7334 32.942 57.0764 32.3633 57.312 31.7263C57.5454 31.0893 57.6667 30.4057 57.6667 29.7173C57.6667 27.4447 55.0814 20.734 53.8914 17.7683C53.7196 17.3428 53.424 16.9785 53.043 16.7227C52.662 16.4669 52.213 16.3313 51.754 16.3333H26.064C25.5916 16.331 25.1298 16.4742 24.7416 16.7435C24.3534 17.0128 24.0574 17.395 23.894 17.8383C22.7717 20.9113 20.3334 27.7783 20.3334 29.7173C20.387 31.094 20.8957 32.396 21.759 33.3737C22.6224 34.349 23.7774 34.93 25 35ZM25 35C25.7654 35 26.519 34.7877 27.1934 34.3793C27.8866 33.9565 28.4639 33.368 28.8734 32.6667H30.4624C30.8705 33.3674 31.4461 33.9559 32.1377 34.3793C32.8144 34.7877 33.568 35 34.3357 35C35.101 35 35.8547 34.7877 36.529 34.3793C37.2057 33.9733 37.782 33.383 38.2067 32.6667H39.7957C40.2045 33.3677 40.781 33.9562 41.4734 34.3793C42.1477 34.7877 42.9014 35 43.6667 35C44.4344 35 45.188 34.7877 45.8647 34.3793C46.5414 33.9733 47.1154 33.383 47.54 32.6667H49.129C49.556 33.383 50.1324 33.9733 50.8067 34.3793C51.4834 34.7853 52.237 35 53.0024 35C53.8923 34.9931 54.7575 34.7066 55.4757 34.181M25 35C23.9899 34.975 23.0242 34.5798 22.2864 33.8893M22.6667 35V51.3333C22.6667 51.9522 22.9125 52.5457 23.3501 52.9833C23.7877 53.4208 24.3812 53.6667 25 53.6667H29.6667V42H36.6667V53.6667H53C53.6189 53.6667 54.2124 53.4208 54.65 52.9833C55.0875 52.5457 55.3334 51.9522 55.3334 51.3333V35M43.6667 42V46.6667H48.3334V42H43.6667Z"
                    stroke="#444444" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                    class="scale-[1.5] translate-y-[-12px] translate-x-[-19px]"  />
            </svg>

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
            <div class="ml-[15px]">
                <svg width="34" height="34" viewBox="0 0 48 48" fill="none" class="flex item-center"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M27.46 42C27.1084 42.6062 26.6037 43.1093 25.9965 43.4591C25.3892 43.8088 24.7008 43.9929 24 43.9929C23.2992 43.9929 22.6108 43.8088 22.0035 43.4591C21.3963 43.1093 20.8916 42.6062 20.54 42M36 16C36 12.8174 34.7357 9.76516 32.4853 7.51472C30.2348 5.26428 27.1826 4 24 4C20.8174 4 17.7652 5.26428 15.5147 7.51472C13.2643 9.76516 12 12.8174 12 16C12 30 6 34 6 34H42C42 34 36 30 36 16Z"
                        stroke="#F4F0EC" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            {{-- Bouton profil --}}
            <div class="hidden sm:flex sm:items-center ml-[15px]">
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
