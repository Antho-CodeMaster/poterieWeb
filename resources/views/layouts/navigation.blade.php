<nav x-data="{ showNav: true }" x-init="if (window.location.pathname === '{{ route('decouverte') }}' || window.location.pathname === '/') {
    showNav = false;
}
window.addEventListener('scroll', () => {
    showNav = window.scrollY >= document.querySelector('#parallax-img').offsetHeight;
});" :class="{ 'hidden': !showNav, 'block': showNav }"
    class="fixed top-0 left-0 w-full h-[48px] z-50 bg-[#c5af9b] border-gray-100 shadow-md transition-all duration-300 ease-in-out"
    x-show="showNav" x-transition:enter="transition ease-in duration-500" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-500"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="z-[102]">

    <!-- Navigation Menu -->
    <div class="flex h-nav justify-between items-center">
        @include('layouts.nav.logo')
        @include('layouts.nav.barre_recherche')

        <!-- Boutons de droite -->
        <div class="flex justify-end w-[225px] items-center mr-[16px]">

            @include('layouts.nav.bouton_recherche')

            {{-- Bouton Admin --}}
            @if (Auth::user() != null)
                @if (Auth::user()->moderateur)
                    @include('layouts.nav.administration')
                @endif

                {{-- Boutons de réglage du kiosque --}}

                @if (Auth::user()->artiste)
                    @if (Auth::user()->artiste->actif == 1)
                        @include('layouts.nav.kiosque')
                    @endif
                @endif
            @endif

            @auth
                @if (!Auth::user()->moderateur && !Auth::user()->artiste)
                    @include('layouts.nav.devenir_vendeur')
                @endif
            @endauth

            @include('layouts.nav.panier')

            @auth
                @include('layouts.nav.notifications')
            @endauth

            <div class="sm:flex sm:items-center z-50 ml-[15px]">
                @auth
                    @include('layouts.nav.settings')
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
    </div>
    {{-- @include('layouts.partials.cookie_banner') --}}
    @include('cookie-consent::index')
</nav>
