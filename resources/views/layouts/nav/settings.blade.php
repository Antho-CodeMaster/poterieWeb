<!-- Authenticated User: Show Dropdown -->
<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <span class="relative group -translate-y-3">
            <button
                class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-200">
                <div class="">
                    <svg width="24" height="34" viewBox="0 0 34 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 36.2857V39.1429C2 39.9006 2.31607 40.6273 2.87868 41.1632C3.44129 41.699 4.20435 42 5 42H29C29.7956 42 30.5587 41.699 31.1213 41.1632C31.6839 40.6273 32 39.9006 32 39.1429V36.2857C32 34.0124 31.0518 31.8323 29.364 30.2248C27.6761 28.6173 25.3869 27.7143 23 27.7143H11C8.61305 27.7143 6.32387 28.6173 4.63604 30.2248C2.94821 31.8323 2 34.0124 2 36.2857ZM26 10.5714C26 12.8447 25.0518 15.0249 23.364 16.6323C21.6761 18.2398 19.3869 19.1429 17 19.1429C14.6131 19.1429 12.3239 18.2398 10.636 16.6323C8.94821 15.0249 8 12.8447 8 10.5714C8 8.29814 8.94821 6.11797 10.636 4.51051C12.3239 2.90306 14.6131 2 17 2C19.3869 2 21.6761 2.90306 23.364 4.51051C25.0518 6.11797 26 8.29814 26 10.5714Z"
                            stroke="#444444" stroke-width="5" />
                    </svg>
                </div>
            </button>
            <!-- Tooltip content -->
            <div
                class="absolute bg-hoverBeige text-md rounded-md p-2 shadow-lg w-fit
            invisible opacity-0 group-hover:visible group-hover:opacity-100 transition duration-200 ease-in-out
            translate-y-2 top-full left-1/2 transform -translate-x-1/2">
                Profil
            </div>
        </span>
    </x-slot>

    <x-slot name="content"> <!-- Changer couleur pour DARKGRAY et BEIGE via preset colors -->
        <div class="bg-[#444444] articleGrand-light rounded-t-lg px-3 mt-0">
            {{ Auth::user()->name }}</div>

        <x-dropdown-link :href="route('profile.edit')" class="hover:underline">
            {{ __('Paramètres du compte') }}
        </x-dropdown-link>

        <x-dropdown-link :href="route('commandes')" class="hover:underline">
            {{ __('Mes commandes') }}
        </x-dropdown-link>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')" class="hover:underline"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
                {{ __('Se déconnecter') }}
            </x-dropdown-link>
        </form>
    </x-slot>
</x-dropdown>
