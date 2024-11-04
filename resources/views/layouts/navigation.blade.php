<nav x-data="{ showNav: true }" x-init="if (window.location.pathname === '{{ route('decouverte') }}' || window.location.pathname === '/') {
    showNav = false;
}
window.addEventListener('scroll', () => {
    showNav = window.scrollY >= document.querySelector('#parallax-img').offsetHeight;
});" :class="{ 'hidden': !showNav, 'block': showNav }"
    class="fixed top-0 left-0 w-full h-[48px] z-50 bg-darkGrey border-gray-100 shadow-md transition-all duration-300 ease-in-out"
    x-show="showNav" x-transition:enter="transition ease-in duration-500" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-500"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <!-- Navigation Menu -->
    <div class="flex h-nav justify-between items-center">

        <!-- Logo -->
        <div class="w-[225px] flex items-center ml-[16px]">
            <a class="navTitre" href="{{ route('decouverte') }}">
                @Terracium
            </a>
        </div>

        <!-- Barre de recherche -->
        <div class="w-[500px]">
            <form action="{{ route('recherche.getSearch', ['search']) }}" method="GET"
                class="w-full h-[38px] py-auto">
                <input class="w-full rounded h-full" type="text" placeholder="Rechercher..." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>


        <!-- Boutons de droite -->
        <div class="flex justify-end w-[225px] items-center mr-[16px]">

            {{-- Bouton Admin --}}
            @if (Auth::user() != null)
                @if (Auth::user()->moderateur)
                    <a href="{{ route('admin') }}" class="ml-[15px] hover:bg-white-700">
                        <svg width="34" height="34" viewBox="0 0 78 78" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect class="w-full h-full" rx="16" fill="#F4F0EC" />
                            <path
                                d="M39 41C42.3137 41 45 38.3137 45 35C45 31.6863 42.3137 29 39 29C35.6863 29 33 31.6863 33 35C33 38.3137 35.6863 41 39 41Z"
                                stroke="#444444" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                class="scale-[1.5] translate-y-[-12px] translate-x-[-19px]" />
                            <path
                                d="M53.8 41C53.5338 41.6032 53.4544 42.2724 53.572 42.9212C53.6896 43.57 53.9989 44.1686 54.46 44.64L54.58 44.76C54.9519 45.1315 55.2469 45.5726 55.4482 46.0582C55.6495 46.5438 55.7531 47.0643 55.7531 47.59C55.7531 48.1157 55.6495 48.6362 55.4482 49.1218C55.2469 49.6074 54.9519 50.0485 54.58 50.42C54.2085 50.7919 53.7674 51.0869 53.2818 51.2882C52.7962 51.4895 52.2757 51.5931 51.75 51.5931C51.2243 51.5931 50.7038 51.4895 50.2182 51.2882C49.7326 51.0869 49.2915 50.7919 48.92 50.42L48.8 50.3C48.3286 49.8389 47.73 49.5296 47.0812 49.412C46.4324 49.2944 45.7632 49.3738 45.16 49.64C44.5685 49.8935 44.064 50.3145 43.7086 50.8511C43.3533 51.3877 43.1626 52.0164 43.16 52.66V53C43.16 54.0609 42.7386 55.0783 41.9884 55.8284C41.2383 56.5786 40.2209 57 39.16 57C38.0991 57 37.0817 56.5786 36.3316 55.8284C35.5814 55.0783 35.16 54.0609 35.16 53V52.82C35.1445 52.158 34.9302 51.516 34.545 50.9774C34.1598 50.4388 33.6215 50.0286 33 49.8C32.3968 49.5338 31.7276 49.4544 31.0788 49.572C30.43 49.6896 29.8314 49.9989 29.36 50.46L29.24 50.58C28.8685 50.9519 28.4274 51.2469 27.9418 51.4482C27.4562 51.6495 26.9357 51.7531 26.41 51.7531C25.8843 51.7531 25.3638 51.6495 24.8782 51.4482C24.3926 51.2469 23.9515 50.9519 23.58 50.58C23.2081 50.2085 22.9131 49.7674 22.7118 49.2818C22.5105 48.7962 22.4069 48.2757 22.4069 47.75C22.4069 47.2243 22.5105 46.7038 22.7118 46.2182C22.9131 45.7326 23.2081 45.2915 23.58 44.92L23.7 44.8C24.1611 44.3286 24.4704 43.73 24.588 43.0812C24.7056 42.4324 24.6262 41.7632 24.36 41.16C24.1065 40.5685 23.6855 40.064 23.1489 39.7086C22.6124 39.3533 21.9836 39.1626 21.34 39.16H21C19.9391 39.16 18.9217 38.7386 18.1716 37.9884C17.4214 37.2383 17 36.2209 17 35.16C17 34.0991 17.4214 33.0817 18.1716 32.3316C18.9217 31.5814 19.9391 31.16 21 31.16H21.18C21.842 31.1445 22.484 30.9302 23.0226 30.545C23.5612 30.1598 23.9714 29.6215 24.2 29C24.4662 28.3968 24.5456 27.7276 24.428 27.0788C24.3104 26.43 24.0011 25.8314 23.54 25.36L23.42 25.24C23.0481 24.8685 22.7531 24.4274 22.5518 23.9418C22.3505 23.4562 22.2469 22.9357 22.2469 22.41C22.2469 21.8843 22.3505 21.3638 22.5518 20.8782C22.7531 20.3926 23.0481 19.9515 23.42 19.58C23.7915 19.2081 24.2326 18.9131 24.7182 18.7118C25.2038 18.5105 25.7243 18.4069 26.25 18.4069C26.7757 18.4069 27.2962 18.5105 27.7818 18.7118C28.2674 18.9131 28.7085 19.2081 29.08 19.58L29.2 19.7C29.6714 20.1611 30.27 20.4704 30.9188 20.588C31.5676 20.7056 32.2368 20.6262 32.84 20.36H33C33.5915 20.1065 34.096 19.6855 34.4514 19.1489C34.8067 18.6124 34.9974 17.9836 35 17.34V17C35 15.9391 35.4214 14.9217 36.1716 14.1716C36.9217 13.4214 37.9391 13 39 13C40.0609 13 41.0783 13.4214 41.8284 14.1716C42.5786 14.9217 43 15.9391 43 17V17.18C43.0026 17.8236 43.1933 18.4524 43.5486 18.9889C43.904 19.5255 44.4085 19.9465 45 20.2C45.6032 20.4662 46.2724 20.5456 46.9212 20.428C47.57 20.3104 48.1686 20.0011 48.64 19.54L48.76 19.42C49.1315 19.0481 49.5726 18.7531 50.0582 18.5518C50.5438 18.3505 51.0643 18.2469 51.59 18.2469C52.1157 18.2469 52.6362 18.3505 53.1218 18.5518C53.6074 18.7531 54.0485 19.0481 54.42 19.42C54.7919 19.7915 55.0869 20.2326 55.2882 20.7182C55.4895 21.2038 55.5931 21.7243 55.5931 22.25C55.5931 22.7757 55.4895 23.2962 55.2882 23.7818C55.0869 24.2674 54.7919 24.7085 54.42 25.08L54.3 25.2C53.8389 25.6714 53.5296 26.27 53.412 26.9188C53.2944 27.5676 53.3738 28.2368 53.64 28.84V29C53.8935 29.5915 54.3145 30.096 54.8511 30.4514C55.3877 30.8067 56.0164 30.9974 56.66 31H57C58.0609 31 59.0783 31.4214 59.8284 32.1716C60.5786 32.9217 61 33.9391 61 35C61 36.0609 60.5786 37.0783 59.8284 37.8284C59.0783 38.5786 58.0609 39 57 39H56.82C56.1764 39.0026 55.5477 39.1933 55.0111 39.5486C54.4745 39.904 54.0535 40.4085 53.8 41Z"
                                stroke="#444444" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                class="scale-[1.5] translate-y-[-13px] translate-x-[-19px]" />
                        </svg>
                    </a>
                @endif

                {{-- Boutons de réglage du kiosque --}}
                @if (Auth::user()->artiste)
                    @if (Auth::user()->artiste->actif == 1)
                        <a href="{{ route('tousMesArticles') }}" class="ml-[15px] flex items-center">
                            <svg width="34" height="34" viewBox="0 0 78 78" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect class="w-full h-full" rx="16" fill="#F4F0EC" />
                                <path
                                    d="M25 35C25.6137 35 26.2227 34.86 26.7897 34.5917C27.3685 34.3179 27.8848 33.9279 28.3064 33.446C28.7404 32.956 29.0834 32.3727 29.3167 31.7333C29.55 31.094 29.6667 30.408 29.6667 29.7173C29.6556 31.0799 30.1418 32.3998 31.034 33.4297C31.909 34.4143 33.0967 34.9673 34.3334 34.9673C35.57 34.9673 36.76 34.4143 37.6327 33.4297C38.525 32.3998 39.0111 31.0799 39 29.7173C38.989 31.0799 39.4751 32.3998 40.3674 33.4297C41.2424 34.4143 42.43 34.9673 43.6667 34.9673C44.9034 34.9673 46.0934 34.4143 46.966 33.4297C47.8583 32.3998 48.3444 31.0799 48.3334 29.7173C48.3334 30.4057 48.4547 31.0893 48.688 31.7263C48.9214 32.3633 49.2667 32.942 49.7007 33.4297C50.1223 33.9088 50.6377 34.2963 51.215 34.5683C51.774 34.8292 52.3833 34.9643 53 34.9643C53.6168 34.9643 54.2261 34.8292 54.785 34.5683C55.3622 34.2949 55.8781 33.9076 56.3017 33.4297C56.7334 32.942 57.0764 32.3633 57.312 31.7263C57.5454 31.0893 57.6667 30.4057 57.6667 29.7173C57.6667 27.4447 55.0814 20.734 53.8914 17.7683C53.7196 17.3428 53.424 16.9785 53.043 16.7227C52.662 16.4669 52.213 16.3313 51.754 16.3333H26.064C25.5916 16.331 25.1298 16.4742 24.7416 16.7435C24.3534 17.0128 24.0574 17.395 23.894 17.8383C22.7717 20.9113 20.3334 27.7783 20.3334 29.7173C20.387 31.094 20.8957 32.396 21.759 33.3737C22.6224 34.349 23.7774 34.93 25 35ZM25 35C25.7654 35 26.519 34.7877 27.1934 34.3793C27.8866 33.9565 28.4639 33.368 28.8734 32.6667H30.4624C30.8705 33.3674 31.4461 33.9559 32.1377 34.3793C32.8144 34.7877 33.568 35 34.3357 35C35.101 35 35.8547 34.7877 36.529 34.3793C37.2057 33.9733 37.782 33.383 38.2067 32.6667H39.7957C40.2045 33.3677 40.781 33.9562 41.4734 34.3793C42.1477 34.7877 42.9014 35 43.6667 35C44.4344 35 45.188 34.7877 45.8647 34.3793C46.5414 33.9733 47.1154 33.383 47.54 32.6667H49.129C49.556 33.383 50.1324 33.9733 50.8067 34.3793C51.4834 34.7853 52.237 35 53.0024 35C53.8923 34.9931 54.7575 34.7066 55.4757 34.181M25 35C23.9899 34.975 23.0242 34.5798 22.2864 33.8893M22.6667 35V51.3333C22.6667 51.9522 22.9125 52.5457 23.3501 52.9833C23.7877 53.4208 24.3812 53.6667 25 53.6667H29.6667V42H36.6667V53.6667H53C53.6189 53.6667 54.2124 53.4208 54.65 52.9833C55.0875 52.5457 55.3334 51.9522 55.3334 51.3333V35M43.6667 42V46.6667H48.3334V42H43.6667Z"
                                    stroke="#444444" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                    class="scale-[1.5] translate-y-[-12px] translate-x-[-19px]" />
                            </svg>
                        </a>
                    @endif
                @endif
            @endif

            {{-- Bouton panier --}}
            <a class="ml-[15px]" href="{{ route('panier') }}">
                <svg width="34" height="34" viewBox="0 0 48 48" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 2H10L15.36 28.78C15.5429 29.7008 16.0438 30.5279 16.7751 31.1166C17.5064 31.7053 18.4214 32.018 19.36 32H38.8C39.7386 32.018 40.6536 31.7053 41.3849 31.1166C42.1162 30.5279 42.6171 29.7008 42.8 28.78L46 12H12M20 42C20 43.1046 19.1046 44 18 44C16.8954 44 16 43.1046 16 42C16 40.8954 16.8954 40 18 40C19.1046 40 20 40.8954 20 42ZM42 42C42 43.1046 41.1046 44 40 44C38.8954 44 38 43.1046 38 42C38 40.8954 38.8954 40 40 40C41.1046 40 42 40.8954 42 42Z"
                        stroke="#F4F0EC" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>

            <!-- Notification Dropdown -->
            @auth
            <div class="sm:flex sm:items-center ml-[15px]">
                <x-dropdown-notification align="right" width="64" class="dropdown-content-class">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="ms-1">
                                <svg width="34" height="34" viewBox="0 0 48 48" fill="none" class="flex items-center" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.46 42C27.1084 42.6062 26.6037 43.1093 25.9965 43.4591C25.3892 43.8088 24.7008 43.9929 24 43.9929C23.2992 43.9929 22.6108 43.8088 22.0035 43.4591C21.3963 43.1093 20.8916 42.6062 20.54 42M36 16C36 12.8174 34.7357 9.76516 32.4853 7.51472C30.2348 5.26428 27.1826 4 24 4C20.8174 4 17.7652 5.26428 15.5147 7.51472C13.2643 9.76516 12 12.8174 12 16C12 30 6 34 6 34H42C42 34 36 30 36 16Z" stroke="#F4F0EC" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#444444] text-[#f4f0ec] font-bold px-3 py-2 text-lg rounded-t-lg">
                            Notifications
                        </div>
                        <div class="overflow-y-auto h-[400px] w-[300px] select-none p-4 space-y-2">
                            @php
                                $visibleNotifications = Auth::user()->notifications->filter(function ($notification) {
                                    return $notification->visible == 1;
                                });
                            @endphp

                            @if ($visibleNotifications->isNotEmpty())
                                @foreach ($visibleNotifications as $notification)
                                    <div x-data="{ slid: false }" class="notification-item">
                                        <div class="relative flex items-center p-4 bg-darkGrey rounded-lg overflow-hidden cursor-pointer" @click="slid = !slid" :class="{ 'translate-x-[-50px]': slid }">
                                            <!-- Notification Content -->
                                            <p class="notification-text flex-1 text-beige">{{ $notification->formatted_description }}</p>
                                        </div>

                                        <!-- Trash Icon -->
                                        <div x-show="slid" class="absolute right-4 top-1/2 transform -translate-y-1/2 transition-opacity duration-200" x-transition.opacity>
                                            <button @click="slid = false; const notificationElement = $el.closest('.notification-item'); hideNotification({{ $notification->id_notification }}, notificationElement)" class="text-red-500 hover:text-red-700 focus:outline-none">
                                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-2">
                                    <span class="font-semibold text-darkGrey">Aucune notification à afficher</span>
                                </div>
                            @endif
                        </div>
                    </x-slot>
                </x-dropdown-notification>
            </div>
            @endauth

            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center ml-[15px]">
                @auth
                    <!-- Authenticated User: Show Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="ms-1">
                                    <svg width="24" height="34" viewBox="0 0 34 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 36.2857V39.1429C2 39.9006 2.31607 40.6273 2.87868 41.1632C3.44129 41.699 4.20435 42 5 42H29C29.7956 42 30.5587 41.699 31.1213 41.1632C31.6839 40.6273 32 39.9006 32 39.1429V36.2857C32 34.0124 31.0518 31.8323 29.364 30.2248C27.6761 28.6173 25.3869 27.7143 23 27.7143H11C8.61305 27.7143 6.32387 28.6173 4.63604 30.2248C2.94821 31.8323 2 34.0124 2 36.2857ZM26 10.5714C26 12.8447 25.0518 15.0249 23.364 16.6323C21.6761 18.2398 19.3869 19.1429 17 19.1429C14.6131 19.1429 12.3239 18.2398 10.636 16.6323C8.94821 15.0249 8 12.8447 8 10.5714C8 8.29814 8.94821 6.11797 10.636 4.51051C12.3239 2.90306 14.6131 2 17 2C19.3869 2 21.6761 2.90306 23.364 4.51051C25.0518 6.11797 26 8.29814 26 10.5714Z"
                                            stroke="#f4f0ec" stroke-width="3.8" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content"> <!-- Changer couleur pour DARKGRAY et BEIGE via preset colors -->
                            <div class="bg-[#444444] text-[#f4f0ec] rounded-t-lg px-3 text-lg font-bold shadow-2xl">
                                {{ Auth::user()->name }}</div>

                            <x-dropdown-link :href="route('profile.edit')" class="hover:underline">
                                {{ __('Paramètres du compte') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('commandes')" class="hover:underline">
                                {{ __('Historique de commandes') }}
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
                @else
                    <!-- Guest User: Show Login Modal Trigger -->
                    <div x-data="{ open: false }">

                        <!-- Include Login & Register Modal -->
                        @include('components.login-modal')
                        @include('components.register-modal')
                    </div>
                @endauth
            </div>
        </div>

        {{--
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
        --}}
    </div>
</nav>
