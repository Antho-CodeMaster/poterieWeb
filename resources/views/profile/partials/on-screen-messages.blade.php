    {{-- Succes de modification de l'unité --}}
    @if (Session::has('succesUnits'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesUnits'),
                'titre' => 'Unité de mesure',
            ])
        </div>
    @endif

    {{-- Succes de modification de l'unité --}}
    @if (Session::has('erreurUnits'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('erreurUnits'),
                'titre' => 'Unité de mesure',
            ])
        </div>
    @endif

    {{-- Succes de modification du floutage --}}
    @if (session('status') === 'blur-updated' && $user->contenu_sensible === 1)
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => 'Les images sensibles ne seront pas floutées.',
                'titre' => 'Accessibilité',
            ])
        </div>
    @endif

    {{-- Succes de modification du floutage --}}
    @if (session('status') === 'blur-updated' && $user->contenu_sensible === 0)
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => 'Les images sensibles seront floutées.',
                'titre' => 'Accessibilité',
            ])
        </div>
    @endif

    @if (session('status') === '2fa-updated')
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => 'Les informations sur la 2FA ont été mises à jour.',
                'titre' => 'Sécurité',
            ])
        </div>
    @endif
