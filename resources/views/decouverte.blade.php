<x-app-layout>
    <div>
        <h1>Découvertes</h1>
        <h2>TEST H2</h2>
        <p>TEST P</p>
        <div class="flex">
            {{-- Possible d'ajouter des attributs --}}
            <x-button.red.trash id="lol">trash</x-button.red.trash>
            {{-- Possible d'override des attributs --}}
            <x-button.red.x type="button">x</x-button.red.x>
            <x-button.red.exclamation>exclamation</x-button.red.exclamation>
            <x-button.red.flag>flag</x-button.red.flag>
        </div>
        <div class="flex">
            <x-button.blue.add-pic>add-pic</x-button.blue.add-pic>
            <x-button.blue.upload>upload</x-button.blue.upload>
            <x-button.blue.leave>leave</x-button.blue.leave>
            <x-button.blue.info>info</x-button.blue.info>
            <x-button.blue.question>question</x-button.blue.question>
            <x-button.blue.edit>edit</x-button.blue.edit>
        </div>
        <div class="flex">
            <x-button.green.check>check</x-button.green.check>
            <x-button.green.award>award</x-button.green.award>
            <x-button.green.card>card</x-button.green.card>
        </div>
        <div class="flex">
            <x-button.red.trash></x-button.red.trash>
            <x-button.red.x></x-button.red.x>
            <x-button.red.exclamation></x-button.red.exclamation>
            <x-button.red.flag></x-button.red.flag>
            <x-button.blue.add-pic></x-button.blue.add-pic>
            <x-button.blue.upload></x-button.blue.upload>
            <x-button.blue.leave></x-button.blue.leave>
            <x-button.blue.info></x-button.blue.info>
            <x-button.blue.question></x-button.blue.question>
            <x-button.blue.edit></x-button.blue.edit>
            <x-button.green.check></x-button.green.check>
            <x-button.green.award></x-button.green.award>
            <x-button.green.card></x-button.green.card>
        </div>
        <div class="flex">
            <x-button.red.empty>empty</x-button.red.empty>
            <x-button.blue.empty>empty</x-button.blue.empty>
            <x-button.green.empty>empty</x-button.green.empty>
        </div>
        <div class="flex">
            <x-button.red.empty></x-button.red.empty>
            <x-button.blue.empty></x-button.blue.empty>
            <x-button.green.empty></x-button.green.empty>
        </div>


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
