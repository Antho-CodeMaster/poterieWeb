<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Veuillez répondre à cette question de sécurité afin de valider votre identité.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" value={{$email}} name="email">

        <!-- Question de sécurité -->
        <div>
            <x-input-label for="reponse" :value="__($question)" />
            <x-text-input id="reponse" class="block mt-1 w-full" type="text" name="reponse" :value="old('reponse')" required autofocus />
            <x-input-error :messages="$errors->get('reponse')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
