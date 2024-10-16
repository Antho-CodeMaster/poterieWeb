<!-- Hamburger menu for small screens -->
<div class="lg:hidden fixed top-12 left-0 w-full bg-beige p-4 z-50">
    <button id="hamburger"
            x-data="{ open: false }"
            x-on:click="open = !open"
            class="flex items-center justify-between w-full focus:outline-none">

        <div class="flex items-center space-x-2">
            <div class="w-6 flex items-center justify-center relative">
                <span x-bind:class="open ? 'translate-y-0 rotate-45' : '-translate-y-2'"
                      class="transform transition w-full h-px bg-current absolute duration-300"></span>

                <span x-bind:class="open ? 'opacity-0 translate-x-3' : 'opacity-100'"
                      class="transform transition w-full h-px bg-current absolute duration-100"></span>

                <span x-bind:class="open ? 'translate-y-0 -rotate-45' : 'translate-y-2'"
                      class="transform transition w-full h-px bg-current absolute duration-300"></span>
            </div>
            <span x-text="open ? 'Fermer' : 'Menu'" class="font-medium text-lg"></span>
        </div>
    </button>
</div>

<!-- Left Menu (Shows different on small vs big screens) -->
<div id="menu-gauche" class="lg:col-span-1 fixed lg:relative lg:top-0 w-full h-full z-40 lg:h-auto lg:shadow-none lg:w-auto hidden lg:flex lg:flex-col overflow-y-auto">
    <!-- Route for each left menus -->
    @if(Route::is('profile*'))
        @include('profile.partials.menu-gauche')
    @endif
</div>
