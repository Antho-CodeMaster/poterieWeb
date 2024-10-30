<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Information d'artiste") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettre à jour votre nom d'artiste.") }}
        </p>
    </header>

    <form method="post" action="{{ route('artiste.updateName') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $artiste->nom_artiste)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="hover:bg-lightVert bg-vert">{{ __('Sauvegarder') }}</x-primary-button>

            @if (session('status') === 'artiste-name-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Sauvegardé.') }}</p>
            @endif
        </div>
    </form>
</section>
