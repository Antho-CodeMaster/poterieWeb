<x-guest-layout>
    <div class="flex flex-col content-height justify-center">
        <h1 class="titre text-center ">Récupérer le mot de passe</h1>
        <div class="mx-auto w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Veuillez répondre à cette question de sécurité afin de valider votre identité.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <input type="hidden" value={{ $email }} name="email">

                <!-- Question de sécurité -->
                <div>
                    <x-input-label for="reponse" :value="__($question)" />
                    <x-text-input id="reponse" class="block mt-1 w-full" type="text" name="reponse" :value="old('reponse')"
                        required autofocus />
                    <!-- Erreur -->
                    <x-input-error :messages="$errors->get('reponse')" class="mt-2 text-red-600 font-bold" />
                    <!-- Session Status (envoi réussi) -->
                    <x-auth-session-status class="mt-2 font-bold" :status="session('status')" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Envoyer le lien de réinitialisation') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
