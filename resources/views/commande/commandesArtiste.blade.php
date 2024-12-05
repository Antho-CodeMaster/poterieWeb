<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col relative">
            <h1 class="m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Mes commandes</h1>

            {{-- Filtres de recherche --}}
            @include('commande.partials.filtresCommandes')

            {{-- Group transactions by commande --}}
            <div class="rounded-[12px] m-sectionY overflow-auto flex flex-wrap gap-inputXXL" id="commandesContainer">

                @include('commande.partials.allTransactions')

                {{-- Succes de la gestion d'une transaction --}}
                @if (Session::has('succesTransaction'))
                    <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
                        @include('messages.messageSucces', [
                            'message' => Session::get('succesTransaction'),
                            'titre' => 'Transaction',
                        ])
                    </div>
                @endif

                {{-- Erreur avec le Tracker --}}
                @if (Session::has('tracker'))
                    <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
                        @include('messages.messageFail', [
                            'message' => Session::get('tracker'),
                            'titre' => 'Erreur de suivi',
                        ])
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
