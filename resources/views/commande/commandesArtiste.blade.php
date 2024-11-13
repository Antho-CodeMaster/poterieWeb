<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col relative">
            <h1 class=" m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Mes commandes</h1>

            {{-- Filtres de recherche --}}
            <form action="" method="post" class="flex justify-between w-full mt-1.5">

                <!-- Barre de recherche -->
                <div id="search-article" class="w-[300px] h-[40px] flex border rounded border-darkGrey">
                    <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                        placeholder="Rechercher par nom..." name="search">
                    <button>
                        <svg class="w-6 h-6 mr-3 text-darkGrey dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </div>

                <div class="flex gap-6">
                    {{-- Filtre type d'usage --}}
                    <select id="typePieceFiltre" name="typePieceFiltre" required
                        class="h-[40px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="" disabled selected hidden>Type d'usage
                        </option>
                        <option value="1">Alimentaire</option>
                        <option value="0">Non alimentaire</option>
                    </select>
                </div>
            </form>

            {{-- Group transactions by commande --}}
            <div class="rounded-[12px] m-sectionY overflow-auto flex flex-wrap gap-inputXXL">
                {{-- Transactions séparées par commandes --}}
                @foreach ($transactions->groupBy('id_commande') as $commandeId => $commandeTransactions)
                    {{-- Vérifie que le paiement a été effectué --}}
                    @if ($commandeTransactions->first()->commande->is_panier == 0)
                        {{-- Regrouppement de tous les transactions --}}
                        <div class="rounded-[12px] flex flex-wrap gap-input w-full mb-2">
                            {{-- Informations de commande --}}
                            <div class="flex w-full p-sectionTop gap-1">

                                <div class="flex flex-col w-[45%]">
                                    {{-- Nom du client acheteur --}}
                                    <div class="flex gap-1 items-baseline w-full">
                                        <p class="textGrand-dark font-bold">Client :</p>
                                        <p class="textGrand-dark text-nowrap text-ellipsis overflow-hidden">
                                            {{ $commandeTransactions->first()->commande->user->name }}</p>
                                    </div>
                                    {{-- Date de prise de commande --}}
                                    <div class="flex gap-1 items-baseline w-full">
                                        <p class="textGrand-dark font-bold">Date de commande :</p>
                                        @if (
                                            $commandeTransactions->first()->commande->no_civique == null ||
                                                $commandeTransactions->first()->commande->rue == null)
                                            <p class="textGrand-dark"> N/A </p>
                                        @else
                                            <p class="textGrand-dark text-nowrap text-ellipsis overflow-hidden"
                                                title="{{ $commandeTransactions->first()->commande->date }}">
                                                {{ $commandeTransactions->first()->commande->date }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col w-[55%]">
                                    <div class="w-full">
                                        <p class="textGrand-dark font-bold">Adresse de livraison :</p>
                                    </div>

                                    {{-- Addresse de livraison  --}}
                                    <div class="flex gap-1 items-baseline w-full">
                                        <p class="textGrand-dark text-nowrap text-ellipsis overflow-hidden">
                                            @if (
                                                $commandeTransactions->first()->commande->no_civique == null ||
                                                    $commandeTransactions->first()->commande->rue == null)
                                                N/A
                                            @else
                                                {{ $commandeTransactions->first()->commande->no_civique }}
                                                {{ $commandeTransactions->first()->commande->rue }},
                                                {{ $commandeTransactions->first()->commande->code_postal }}
                                                {{ $commandeTransactions->first()->commande->ville->ville }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                                {{-- <p>{{ $transaction->commande->ville->ville }}</p> --}}
                            </div>

                            {{-- Date de prise de commande --}}
                            <div class="flex gap-1 items-baseline w-[19%]">
                                <p class="textGrand-dark font-bold">Date:</p>
                                @if (
                                    $commandeTransactions->first()->commande->no_civique == null ||
                                        $commandeTransactions->first()->commande->rue == null)
                                    <p class="textGrand-dark"> N/A </p>
                                @else
                                    <p class="textGrand-dark text-nowrap text-ellipsis overflow-hidden">
                                        {{ $commandeTransactions->first()->commande->date }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex w-full p-sectionX p-sectionTop gap-1 underline">
                            <a href="/facture/vente/{{$commandeId}}" target="_blank">Facture</a>
                        </div>

                        {{-- Transactions qui ont besoin d'être traitées --}}
                        @foreach ($commandeTransactions->sortBy('id_etat') as $transaction)
                            <div
                                class="flex gap-input rounded-[12px] bg-beige w-full p-sectionX p-sectionY border-[2px]
                                {{ $transaction->id_etat == 2 ? 'border-jauneWarning' : '' }}
                                {{ $transaction->id_etat == 3 ? 'border-blue-700' : '' }}
                                {{ $transaction->id_etat == 4 ? 'border-vertSucces' : '' }}
                                 {{ $transaction->id_etat == 5 ? 'border-rougeFail' : '' }}">

                                    {{-- Image de l'article --}}
                                    <img src="/../img/{{ $transaction->article->photosArticle->path }}"
                                        alt="Photo d'article"
                                        class="z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[100px] w-[100px] object-cover">
                                    {{-- certains images ne prennent pas la width voulue --}}

                                    <div class="w-[15%] flex flex-col gap-1 justify-between">
                                        {{-- Prix unitaire --}}
                                        <div class="w-full flex flex-col gap-1">
                                            <p class="textMoyen-dark font-bold">Prix unitaire:</p>
                                            <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                {{ $transaction->prix_unitaire }}$</p>
                                        </div>

                                        {{-- Quantité --}}
                                        <div class="w-full flex flex-col gap-1">
                                            <p class="textMoyen-dark font-bold">Quantité:</p>
                                            <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                {{ $transaction->quantite }}</p>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="w-[10%] flex flex-col gap-1">
                                        <p class="textMoyen-dark font-bold">Statut:</p>
                                        <p
                                            class="textMoyen underline font-bold text-nowrap text-ellipsis overflow-hidden {{-- Bug de couleur de texte --}}
                                        {{ $transaction->id_etat == 2 ? 'text-jauneWarning' : '' }}
                                        {{ $transaction->id_etat == 3 ? 'text-blue-700' : '' }}
                                        {{ $transaction->id_etat == 4 ? 'text-vertSucces' : '' }}
                                        {{ $transaction->id_etat == 5 ? 'text-rougeFail' : '' }}">
                                            {{ $transaction->etat_transaction->etat }}
                                        </p>
                                    </div>

                                    <div class="w-[30%] flex flex-col gap-1 justify-between">
                                        {{-- Date de récéption prévue --}}
                                        <div class="w-full flex flex-col gap-1">
                                            <p class="textMoyen-dark font-bold">Date de réception prévue:</p>
                                            @if ($transaction->id_etat == 3 || $transaction->id_etat == 4 || $transaction->id_etat == 5)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    {{ $transaction->date_reception_prevue }}
                                                </p>
                                            @elseif ($transaction->id_etat == 2)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    Pas encore définie
                                                </p>
                                            @else
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    N/A
                                                </p>
                                            @endif
                                        </div>

                                        {{-- Date de récéption prévue --}}
                                        <div class="w-full flex flex-col gap-1">
                                            <p class="textMoyen-dark font-bold">Date de réception effective:</p>
                                            @if ($transaction->id_etat == 4)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    {{ $transaction->date_reception_effective }}
                                                </p>
                                            @elseif ($transaction->id_etat == 5)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    N/A
                                                </p>
                                            @elseif ($transaction->id_etat == 2 || $transaction->id_etat == 3)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    Pas encore livré
                                                </p>
                                            @endif
                                        </div>
                                    </div>


                                    {{-- numéro de livraison et compagnie --}}
                                    <div class="w-[20%] flex flex-col gap-1 justify-between">
                                        <div class="w-full flex flex-col gap-1">
                                            <p class="textMoyen-dark font-bold">Compagnie:</p>
                                            @if ($transaction->id_etat == 3 || $transaction->id_etat == 4)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    {{ $transaction->compagnie_livraison->compagnie }}
                                                </p>
                                            @else
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    N/A
                                                </p>
                                            @endif
                                        </div>
                                        <div class="w-full flex flex-col gap-1">
                                            <p class="textMoyen-dark font-bold">Numéro de suivi:</p>
                                            @if ($transaction->id_etat == 3)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    {{ $transaction->code_ref_livraison }}
                                                </p>
                                            @elseif ($transaction->id_etat == 3)
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    Déja livré
                                                </p>
                                            @else
                                                <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                                    N/A
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Bouton pour traiter la commande --}}
                                    @if ($transaction->id_etat == 2)
                                        <form
                                            action="{{ route('traiterTransactionForm', ['idTransaction' => $transaction->id_transaction]) }}"
                                            method="get" class="flex items-center grow">
                                            @csrf
                                            <x-button.yellow.empty class="w-full">
                                                Traiter
                                            </x-button.yellow.empty>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
                {{-- Message de Session --}}
                {{-- Succes de la gestion d'une transaction --}}
                @if (Session::has('succesTransaction'))
                    <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
                        @include('messages.messageSucces', [
                            'message' => Session::get('succesTransaction'),
                            'titre' => 'Transaction',
                        ])
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
