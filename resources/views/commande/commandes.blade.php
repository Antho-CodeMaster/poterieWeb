<x-app-layout>

    <h1 class="my-8 text-center titre1-dark">Commandes</h1>
    @php
        $colors = [
            'Traité' => '#0000FF',
            'Livré' => '#009b4d',
            'En cours' => '#ffb700',
            'Annulé' => '#FF0000',
        ];
    @endphp

    <div class="hidden text-[#FF0000] text-[#ffb700] text-[#009b4d] text-[#0000FF]"></div>
    {{-- Si aucune commande en cours on affiche un message, sinon on affiche les commandes --}}
    @if ($commandes->isEmpty())
        <p class="text-center titre2-dark">Aucune commande</p>
        <p class="text-center mt-4">Vous n'avez jamais effectué de commande chez Artterre.</p>
    @else
        @if ($commandeEnCours != null)
            <h2 class="my-8 titre2-dark m-section">En cours</h2>

            @foreach ($commandeEnCours as $commande)
                {{-- ex layout une commande --}}
            <div class="lg:flex border border-darkGrey mx-6 md:mx-32 my-5 rounded p-2 md:p-8">
                    {{-- images --}}
                    <div class="w-full lg:w-1/3 flex relative space-x-0 my-2">
                        @foreach ($commande->transactions as $transaction)
                            <img src="{{ 'img/' . $transaction->article->photo_article[0]->path }}" alt=""
                                class="aspect-square w-1/3 h-full object-cover z-{{ $loop->iteration * 10 }} rounded-[12px] shadow-xl shadow-black {{ $loop->first === true ? '' : 'absolute left-[' . ($loop->iteration - 1) * 25 . '%]' }} ">
                            @if ($loop->iteration == 3)
                            @break
                            @endif
                        @endforeach
                    </div>

                {{-- infos --}}
                <div class="flex flex-wrap lg:flex-col w-full lg:w-1/3 justify-between mt-6">
                    <p class="textGrand-dark">Date : {{ $commande->date }} </p>

                    @php $etat = $commande->transactions[0]->etat_transaction->etat @endphp
                    <p class="textGrand-dark">Statut :
                        <span class="text-[{{ $colors[$etat] }}] underline">
                            {{ $etat === 'Annulé' ? ' Attention requise' : ' ' . $etat }}</span>
                    </p>

                    <p class="textGrand-dark"> {{ sizeof($commande->transactions) }} article(s)</p>
                </div>

                {{-- prix --}}
                <div class="flex flex-col w-full lg:w-1/3 justify-between my-2">
                    <form method="get" action="{{ $commande->receipt_url }}" class="my-2">
                        <x-button.blue.download>Télécharger le reçu</x-button.blue.download>
                    </form>
                    <form method="get" action="/commande/{{ $commande->id_commande }}" class="my-2">
                        <x-button.blue.info>Détails de la commande</x-button.blue.info>
                    </form>
                    @php
                        $prix = 0.0;
                        foreach ($commande->transactions as $transaction) {
                            $prix += $transaction->prix_unitaire * $transaction->quantite;
                        }
                        $prix *= 1.15;
                    @endphp
                    <p class="textGrand-dark font-bold mt-2">Total : {{ number_format($prix, 2, ',', ' ') }} $</p>
                </div>
            </div>
        @endforeach
    @endif

    @if ($commandeFini != null)
        <h2 class="my-8 titre2-dark m-section">Précédent</h2>

        @if (empty($commandeFini))
            <p class="mx-5">Aucune commande précédente</p>
        @endif

        @foreach ($commandeFini as $commande)
                {{-- ex layout une commande --}}
            <div class="lg:flex border border-darkGrey my-5 rounded p-8 mx-6 md:mx-32">
                {{-- images --}}
                <div class="w-full lg:w-1/3 flex relative space-x-0">
                    @foreach ($commande->transactions as $transaction)
                        <img src="{{ 'img/' . $transaction->article->photo_article[0]->path }}" alt=""
                            class="aspect-square w-1/3 h-full object-cover z-{{ $loop->iteration * 10 }} rounded-[12px] shadow-xl shadow-black {{ $loop->first === true ? '' : 'absolute left-[' . ($loop->iteration - 1) * 25 . '%]' }} ">
                        @if ($loop->iteration == 3)
                            @break
                        @endif
                    @endforeach
                </div>

                {{-- infos --}}
                <div class="flex flex-wrap lg:flex-col w-full lg:w-1/3 justify-between mt-6">
                    <p class="textGrand-dark">Date : {{ $commande->date }} </p>

                    @php $etat = $commande->transactions[0]->etat_transaction->etat @endphp
                    <p class="textGrand-dark">Statut :
                        <span class="text-[{{ $colors[$etat] }}] underline">
                            {{ $etat === 'Annulé' ? ' Attention requise' : ' ' . $etat }}</span>
                    </p>

                    <p class="textGrand-dark"> {{ sizeof($commande->transactions) }} article(s)</p>
                </div>

                {{-- prix --}}
                <div class="flex flex-col w-full lg:w-1/3 justify-between my-2">
                    <form method="get" action="{{ $commande->receipt_url }}" class="my-2">
                        <x-button.blue.download>Télécharger le reçu</x-button.blue.download>
                    </form>
                    <form method="get" action="/commande/{{ $commande->id_commande }}" class="my-2">
                        <x-button.blue.info>Détails de la commande</x-button.blue.info>
                    </form>
                    @php
                        $prix = 0.0;
                        foreach ($commande->transactions as $transaction) {
                            $prix += $transaction->prix_unitaire * $transaction->quantite;
                        }
                        $prix *= 1.15;
                    @endphp
                    <p class="textGrand-dark font-bold mt-2">Total : {{ number_format($prix, 2, ',', ' ') }} $</p>
                </div>
            </div>
        @endforeach
    @endif
@endif


</x-app-layout>
