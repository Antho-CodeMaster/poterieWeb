<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Oublié votre mot de passe? Aucun problème. Entrez votre adresse courriel, nous vérifierons votre identité et vous enverrons un lien de rénitialisation qui vous permettra d\'en choisir un nouveau.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="GET" action="{{ route('password.question') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Vérifiez mon identité!') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
