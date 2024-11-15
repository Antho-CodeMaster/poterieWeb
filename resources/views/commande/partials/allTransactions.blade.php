{{-- Transactions séparées par commandes --}}
@foreach ($commandeTransactions as $commandeId => $commandeTransactions)
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

                <div class="flex flex-col w-[45%]">
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
                                @php
                                    $codePostal = $commandeTransactions->first()->commande->code_postal;
                                    $codePostal =
                                        strtoupper(substr($codePostal, 0, 3)) .
                                        ' ' .
                                        strtoupper(substr($codePostal, 3));
                                @endphp
                                {{ $codePostal }}
                                {{ $commandeTransactions->first()->commande->ville->ville }}
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Bouton pour voir la facture de vente de cette commande --}}
                <div class="flex w-[10%] justify-center items-end underline">
                    <a href="/facture/vente/{{ $commandeId }}" target="_blank"
                        class=" hover:text-blue-700 p-sectionX">Facture</a>
                </div>
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
                    <img src="/../img/{{ $transaction->article->photosArticle->path }}" alt="Photo d'article"
                        class="z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[100px] w-[100px] object-cover">

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