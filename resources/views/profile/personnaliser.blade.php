<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <!-- Left Menu -->
        <div class="max-w-xl">
            @include('components.mobile-left-menu')
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-5 grid grid-cols-1 lg:grid-cols-4 gap-6 py-8 mx-4">
            <div class="col-span-5 p-4 sm:p-8">
                @include('components.color-picker')
            </div>

            <!-- Update profile picture -->
            @if ($artiste)
                <div class="lg:col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-picture-form')
                    </div>
                </div>
            @else
                <span class="col-span-2 p-4 sm:p-8"></span>
            @endif
        </div>
    </div>
</x-app-layout>
