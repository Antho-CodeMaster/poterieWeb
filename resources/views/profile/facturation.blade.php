<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6 lg:min-h-screen relative lg:top-0 top-12 lg:mb-0 mb-12">
        <!-- Left Menu -->
        <div class="max-w-xl">
            @include('components.mobile-left-menu')
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-5 grid grid-cols-1 lg:grid-cols-4 gap-6 py-8 mx-4 h-fit">
            <div class="lg:col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.edit-payment-method-form')
                </div>
            </div>
            <span></span>
            <span></span>
            @if ($subbed == true)
                <div class="lg:col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.cancel-subscription-form')
                    </div>
                </div>
                <span></span>
                <span></span>
            @elseif ($was_subbed == true)
                <div class="lg:col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.sub-again-form')
                    </div>
                </div>
                <span></span>
                <span></span>
            @endif

            @if ($artiste !=null)
                <div class="lg:col-span-2 p-4 sm:p-8 bg-beige hover:shadow-lg rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.add-payout-info-form')
                    </div>
                </div>
            @endif
        </div>
        @if (Session::has('succes'))
            <div class="w-fit absolute right-2 bottom-10">
                @include('messages.messageSucces', [
                    'message' => Session::get('succes'),
                    'titre' => 'Succès',
                ])
            </div>
        @endif
    </div>
</x-app-layout>
