<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6 lg:min-h-screen relative lg:top-0 top-12 lg:mb-0 mb-12">
        <!-- Left Menu -->
        <div class="max-w-xl">
            @include('components.mobile-left-menu')
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-5 grid grid-cols-2 lg:grid-cols-4 gap-6 py-8 mx-4 h-fit">
            <div class="lg:col-span-5 col-span-1 p-4 sm:p-8">
                @include('components.color-picker')
            </div>

            <!-- Update artiste picture -->
            <div class="lg:col-span-1 col-span-1 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-picture-form')
                </div>
            </div>

            <!-- Update artiste name -->
            <div class="col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-artiste-name-form')
                </div>
            </div>

            <!-- Update artiste social medias -->
            <div class="lg:col-span-3 col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-social-media-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
