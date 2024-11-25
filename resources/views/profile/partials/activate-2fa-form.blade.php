<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Sécurité') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Authentification multifactorielle") }}
        </p>
    </header>

    @if ($user->uses_2fa)
    <form method="post" action="{{ route('2fa.deactivate') }}" class="mt-6 space-y-6" id="2faForm">
        @csrf
        <x-primary-button class="hover:bg-[#FA3D3D] bg-rouge">{{ __('Désactiver') }}</x-primary-button>
    </form>
    @else
    <div x-data="{ show2FAForm: {{session('status') === '2fa-failed' ? 'true' : 'false'}} }">
        <div class="mt-6 space-y-6">
            <x-primary-button type='button' x-on:click="show2FAForm = !show2FAForm" class="hover:bg-lightVert bg-vert" x-bind:class="{ 'hidden': show2FAForm }">{{ __('Activer') }}</x-primary-button>
        </div>
        <form method="post" action="{{ route('2fa.activate') }}" class="mt-6 space-y-6" id="2faForm" x-bind:class="{ 'hidden': !show2FAForm }">
            @csrf

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Pour activer la validation en deux étapes (2FA), scannez le code QR affiché à l’aide d’une application d’authentification comme Google Authenticator ou Authy. Une fois le code ajouté à l’application, un code à 6 chiffres généré apparaîtra. Entrez ce code dans le champ prévu, puis validez pour activer la sécurité.") }}
            </p>
            <div>
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
            </div>

            <div>
                <x-input-label for="one_time_password" :value="__('Code à 6 chiffres :')" />
                <x-text-input id="one_time_password" name="one_time_password" type="text" class="mt-1 block w-full" required autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('one_time_password')" />
            </div>


            <x-primary-button class="hover:bg-lightVert bg-vert">{{ __('Activer') }}</x-primary-button>

        </form>
        @if (session('status') === '2fa-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Sauvegardé.') }}</p>
        @endif
    </div>

    @endif


</section>
