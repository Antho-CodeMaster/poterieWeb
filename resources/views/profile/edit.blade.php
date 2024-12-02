<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6 lg:min-h-screen relative lg:top-0 top-12 lg:mb-0 mb-12">

        <div class="max-w-xl">
            @include('components.mobile-left-menu')
        </div>

        <!-- Main Content (Profile Information + Password Update + Accessibility + Delete User + Update Profile Picture) -->
        <div class="lg:col-span-5 grid grid-cols-1 lg:grid-cols-4 gap-6 py-8 mx-4 h-fit">
            <!-- Profile Information -->
            <div class="col-span-2">
                <div class="p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>
            <!-- 2fa -->
            <div class="col-span-2 p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.activate-2fa-form')
                </div>
            </div>

            <!-- Password Update -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Accessibilité -->
            <div class="col-span-2 sm:col-span-1 p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-blur-form')
                </div>
            </div>

            <!-- unités -->
            <div class="col-span-2 sm:col-span-1 p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-units-form')
                </div>
            </div>

            <!-- Question de sécurité  -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-security-question-form')
                </div>
            </div>

            <span></span>
            <span></span>

            <!-- Delete account -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
    @include('profile.partials.on-screen-messages')
</x-app-layout>
