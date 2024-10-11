<x-app-layout>
    <div>
        <h1>Découvertes</h1>
        <h2>TEST H2</h2>
        <p>TEST P</p>
        @if (Session::all())
            {{-- Modal de remerciement d'avoir envoyé une demande --}}
            @if (Session::has('succesDemande'))
                @include('components.devenir-artiste-succes-modal')
            @endif
            {{-- Span qui, s'il existe, va trigger l'ouvertur du modal de connexion --}}
            @if (Session::has('succesRecupMdp'))
                <span id="showLoginModal" class="hidden"></span>
            @endif
        @endif

    </div>
</x-app-layout>
