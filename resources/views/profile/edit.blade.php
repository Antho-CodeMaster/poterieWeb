<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Left Menu -->
        <div class="lg:col-span-1">
            @include('profile.partials.menu-gauche')
        </div>

        <!-- Main Content (Profile Information + Password Update + Accessibilité) -->
        <div class="lg:col-span-3 grid grid-cols-1 lg:grid-cols-2 gap-6 py-12 mx-4">
            <!-- Profile Information -->
            <div class="col-span-1 p-4 sm:p-8 bg-beige shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Accessibilité -->
            <div class="col-span-1 p-4 sm:p-8 bg-beige shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-blur-form')
                </div>
            </div>

            <!-- Password Update (Full Width in Two Columns) -->
            <div class="col-span-1 p-4 sm:p-8 bg-beige shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
