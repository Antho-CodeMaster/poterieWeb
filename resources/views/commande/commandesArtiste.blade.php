<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col">
            <h1 class=" m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Mes commandes</h1>

            {{-- Filtres de recherche --}}
            <form action="" method="post" class="flex justify-between w-full">

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
                        <option value="0">Non-alimentaire</option>
                    </select>
                </div>
            </form>

            {{-- Titre d'infos --}}
            <div class="w-full flex justify-between p-sectionY">
                <p class="textGrand-dark">image</p>
                <p class="textGrand-dark">image</p>
                <p class="textGrand-dark">image</p>
                <p class="textGrand-dark">image</p>
            </div>

            {{-- Group transactions by commande --}}
            <div class="rounded-[12px] m-sectionY overflow-auto flex flex-wrap gap-input">
                {{-- Transactions séparées par commandes --}}
                @foreach ($transactions->groupBy('id_commande') as $commandeId => $commandeTransactions)
                    {{-- @foreach ($commandeTransactions as $transaction)
                        @switch($transaction->id_etat)
                            @case(2)

                                @break

                            @default

                        @endswitch
                    @endforeach --}}

                    {{-- Regrouppement de tous les transactions --}}
                    <div class="rounded-[12px] flex flex-wrap gap-input w-full mb-2">

                        {{-- Informations de commande --}}
                        <div class="flex w-full p-sectionX p-sectionTop gap-1">
                            {{-- Nom du client acheteur --}}
                            <div class="flex gap-1 items-baseline w-[27%]">
                                <p class="textGrand-dark font-bold">Client:</p>
                                <p class="textGrand-dark text-nowrap text-ellipsis overflow-hidden">
                                    {{ $commandeTransactions->first()->commande->user->name }}</p>
                            </div>

                            {{-- Addresse de livraison  --}}
                            <div class="flex gap-1 items-baseline w-[54%]">
                                <p class="textGrand-dark font-bold">Addresse de livraison:</p>
                                <p class="textGrand-dark">
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

                        {{-- Transactions qui ont besoin d'être traitées --}}
                        @foreach ($commandeTransactions->sortBy('id_etat') as $transaction)
                            <div
                                class="rounded-[12px] bg-beige w-full p-sectionX p-sectionY border-[2px]
                                {{ $transaction->id_etat == 2 ? 'border-jauneWarning' : '' }}
                                {{ $transaction->id_etat == 3 ? 'border-vertSucces' : '' }}
                                {{ $transaction->id_etat == 4 ? 'border-blue-700' : '' }}
                                 {{ $transaction->id_etat == 5 ? 'border-rougeFail' : '' }}">

                                {{-- Image de l'article --}}
                                <img src="/../img/{{ $transaction->article->photosArticle->path }}"
                                    alt="Photo d'article"
                                    class="z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[100px] w-[100px] object-cover">

                                {{-- Prix unitaire --}}
                                <div class="flex gap-1 items-baseline w-[27%]">
                                    <p class="textMoyen-dark font-bold">Prix:</p>
                                    <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                        {{ $transaction->prix_unitaire }}$</p>
                                </div>

                                {{-- Quantité --}}
                                <div class="flex gap-1 items-baseline w-[27%]">
                                    <p class="textMoyen-dark font-bold">Quantité:</p>
                                    <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                        {{ $transaction->quantite }}</p>
                                </div>

                                {{-- Status --}}
                                <div class="flex gap-1 items-baseline w-[27%]">
                                    <p class="textMoyen-dark font-bold">Status:</p>
                                    <p
                                        class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden {{-- Bug de couleur de texte --}}
                                        {{ $transaction->id_etat == 2 ? 'text-jauneWarning' : '' }}
                                        {{ $transaction->id_etat == 3 ? 'text-vertSucces' : '' }}
                                        {{ $transaction->id_etat == 4 ? 'text-blue-700' : '' }}
                                        {{ $transaction->id_etat == 5 ? 'text-rougeFail' : '' }}">
                                        {{ $transaction->etat_transaction->etat }}
                                    </p>
                                </div>

                                {{-- Date de récéption prévue --}}
                                <div class="flex gap-1 items-baseline w-[27%]">
                                    <p class="textMoyen-dark font-bold">Date de réception pévue:</p>
                                    @if ($transaction->id_etat == 3 || $transaction->id_etat == 4)
                                        <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                            {{ $transaction->date_reception_prevue }}
                                        </p>
                                    @else
                                        <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                            N/A
                                        </p>
                                    @endif
                                </div>

                                {{-- Date de récéption prévue --}}
                                <div class="flex gap-1 items-baseline w-[27%]">
                                    <p class="textMoyen-dark font-bold">Date de réception effective:</p>
                                    @if ($transaction->id_etat == 4)
                                        <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                            {{ $transaction->date_reception_effective }}
                                        </p>
                                    @else
                                        <p class="textMoyen-dark text-nowrap text-ellipsis overflow-hidden">
                                            N/A
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
