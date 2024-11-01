<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <!-- Left Menu -->
        <div class="max-w-xl">
            @include('components.mobile-left-menu')
        </div>

        <!-- Main Content -->
        <div x-data = "{link:'{{route('stripe.facturation')}}'}" class="lg:col-span-5 grid grid-cols-1 lg:grid-cols-4 gap-6 py-8 mx-4">
            <x-button.green.pay type="button" @click="window.location.href=link">Définir informations de facturation</x-button.green.pay>
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
