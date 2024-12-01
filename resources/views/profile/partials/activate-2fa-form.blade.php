<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Sécurité') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettre en place l'authentification à deux facteurs afin de mieux sécuriser votre compte.") }}
        </p>
        <a href="https://www.microsoft.com/fr-ca/security/business/security-101/what-is-two-factor-authentication-2fa">
            <p class="mt-1 text-sm text-blue-600 hover:underline">
                {{ __("Plus d'informations sur la 2FA") }}
            </p>
        </a>
    </header>

    @if ($user->uses_2fa)
    <form method="post" action="{{ route('2fa.deactivate') }}" class="mt-6 space-y-6" id="2faForm">
        @csrf
        <x-button.red.empty class="hover:bg-[#FA3D3D] bg-rouge">{{ __('Désactiver') }}</x-button.red.empty>
    </form>
    @else
    <div x-data="{ show2FAForm: {{session('status') === '2fa-failed' ? 'true' : 'false'}} }">
        <div class="mt-6 space-y-6">
            <x-button.green.empty type='button' x-on:click="show2FAForm = !show2FAForm" class="hover:bg-lightVert bg-vert" x-bind:class="{ 'hidden': show2FAForm }">{{ __('Activer') }}</x-button.green.empty>
        </div>
        <form x-cloak method="post" action="{{ route('2fa.activate') }}" class="mt-6 space-y-6" id="2faForm" x-bind:class="{ 'hidden': !show2FAForm }">
            @csrf

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Pour activer la validation en deux étapes (2FA), scannez le code QR affiché ci-bas à l’aide d’une application d’authentification telle Google Authenticator ou Authy. Une fois le code QR ajouté à l’application, un code à 6 chiffres généré apparaîtra. Entrez ce code dans le champ prévu, puis validez pour activer la sécurité.") }}
            </p>
            <div>
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
            </div>

            <div>
                <x-input-label for="one_time_password" :value="__('Code à 6 chiffres :')" />
                <x-text-input id="one_time_password" name="one_time_password" type="text" class="mt-1 block w-full" required autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('one_time_password')" />
            </div>
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Vous serez désormais invités à entrer ce code à chaque connexion à votre compte.") }}
            </p>


            <x-button.green.empty class="hover:bg-lightVert bg-vert">{{ __('Activer') }}</x-button.green.empty>

        </form>
    </div>

    @endif


</section>
