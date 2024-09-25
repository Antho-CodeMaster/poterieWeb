<!-- Navigation Menu -->
<div class="w-[20%] h-[100vh] bg-lightGrey">

    <!-- Boutons de droite -->
    <div class="items-center">

        {{-- Bouton Utilisateurs --}}
        <a href="{{ route('admin-utilisateurs') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() ==  'admin/utilisateurs' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                    clip-rule="evenodd" />
            </svg>
            <p class="text-2xl text-darkGrey">Utilisateurs</p>
        </a>

        {{-- Bouton Publications --}}
        <a href="{{ route('admin-publications') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() ==  'admin/publications' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z"
                    clip-rule="evenodd" />
            </svg>

            <p class="text-2xl text-darkGrey">Publications</p>
        </a>

        {{-- Bouton Signalements --}}
        <a href="{{ route('admin-signalements') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() ==  'admin/signalements' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                    d="m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            <p class="text-2xl text-darkGrey">Signalements</p>
        </a>

        {{-- Bouton Demandes d'inscription --}}
        <a href="{{ route('admin-demandes') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() ==  'admin/demandes' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                    clip-rule="evenodd" />
            </svg>

            <p class="text-2xl text-darkGrey">Demandes d'inscription</p>
        </a>

        {{-- Bouton Articles non reçus --}}
        <a href="{{ route('admin-articles-non-recus') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() ==  'admin/articles-non-recus' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z"
                    clip-rule="evenodd" />
            </svg>

            <p class="text-2xl text-darkGrey">Articles non reçus</p>
        </a>

        {{-- Bouton Transactions --}}
        <a href="{{ route('admin-transactions') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() ==  'admin/transactions' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                    clip-rule="evenodd" />
            </svg>

            <p class="text-2xl text-darkGrey">Transactions</p>
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
</div>
