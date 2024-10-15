<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6 relative">
        <!-- Hamburger Menu for Small Screens -->
        <div class="lg:hidden p-4 fixed top-10 left-0 z-50">
            <!-- Button to toggle the menu -->
            <button id="hamburger" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Left Menu -->
        <div id="menu-gauche" class="lg:col-span-1 fixed lg:relative top-0 h-full w-[250px] bg-white shadow-lg z-40 lg:h-auto lg:shadow-none lg:w-auto lg:static hidden lg:flex lg:flex-col overflow-y-auto">
            @include('profile.partials.menu-gauche')
        </div>

        <!-- Main Content (Profile Information + Password Update + Accessibility + Delete User + Update Profile Picture) -->
        <div class="lg:col-span-5 grid grid-cols-1 lg:grid-cols-4 gap-6 py-8 mx-4">
            <!-- Profile Information -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Accessibilité -->
            <div class="col-span-1 p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-blur-form')
                </div>
            </div>

            <!-- Update profile picture -->
            @if ($artiste)
                <div class="col-span-1 p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-picture-form')
                    </div>
                </div>
            @else
            <span class="col-span-1 p-4 sm:p-8"></span>
            @endif

            <!-- Password Update -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <span class="col-span-2 p-4 sm:p-8"></span>

            <!-- Delete account -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
