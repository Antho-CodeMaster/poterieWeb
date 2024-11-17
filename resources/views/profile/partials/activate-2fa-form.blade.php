<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Sécurité') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Authentification multifactorielle") }}
        </p>
    </header>

    @if (!$user->uses_two_factor_auth)
    <form method="post" action="{{ route('2fa.deactivate') }}" class="mt-6 space-y-6" id="2faForm">
        <x-primary-button class="hover:bg-[#FA3D3D] bg-rouge">{{ __('Désactiver') }}</x-primary-button>
    </form>
    @else
    <div x-data="{ show2FAForm: false }">
        <x-primary-button type='button' x-on:click="show2FAForm = !show2FAForm" class="hover:bg-lightVert bg-vert">{{ __('Activer') }}</x-primary-button>

        <form method="post" action="{{ route('2fa.activate') }}" class="mt-6 space-y-6 bg-black" id="2faForm" x-bind:class="{ 'hidden': !show2FAForm }">
            @csrf



            @if (session('status') === '2fa-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Sauvegardé.') }}</p>
        @endif
        </form>
    </div>

    @endif


</section>
