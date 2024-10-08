<x-app-layout>
    <div>
        <h1>Découvertes</h1>
        <h2>TEST H2</h2>
        <p>TEST P</p>
        {{-- Modal de remerciement d'avoir envoyé une demande --}}
        @if (Session::all())
            @if (Session::has('succesDemande'))
                @include('components.devenir-artiste-succes-modal')
            @endif
        @endif
    </div>
</x-app-layout>
