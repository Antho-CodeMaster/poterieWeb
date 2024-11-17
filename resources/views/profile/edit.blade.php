<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6 relative">

        <div class="max-w-xl">
            @include('components.mobile-left-menu')
        </div>

        <!-- Main Content (Profile Information + Password Update + Accessibility + Delete User + Update Profile Picture) -->
        <div class="lg:col-span-5 grid grid-cols-1 lg:grid-cols-4 gap-6 py-8 mt-4 mx-4">
            <!-- Profile Information -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div>
                <!-- Accessibilité -->
                <div class="col-span-1 p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-blur-form')
                    </div>
                </div>


                <!-- unités -->
                <div class="col-span-1 p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-units-form')
                    </div>
                </div>

            </div>

            <span class="col-span-1 p-4 sm:p-8"></span>

            <!-- Password Update -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- 2fa -->
            <div>
                <div class="col-span-1 p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.activate-2fa-form')
                    </div>
                </div>
            </div>



            <!-- Delete account -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    {{-- Succes de modification de l'unité --}}
    @if (Session::has('succesUnits'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesUnits'),
                'titre' => 'Unité de mesure',
            ])
        </div>
    @endif

    {{-- Succes de modification de l'unité --}}
    @if (Session::has('erreurUnits'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('erreurUnits'),
                'titre' => 'Unité de mesure',
            ])
        </div>
    @endif
</x-app-layout>
