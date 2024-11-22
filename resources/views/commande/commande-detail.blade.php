<x-app-layout>
    @php
        $colors = [
            'Traité' => '#0000FF',
            'Livré' => '#009b4d',
            'En cours' => '#ffb700',
            'Annulé' => '#FF0000',
            'Panier' => '#FF0000',
        ];
        $tooltips = [
            'Traité' => "La commande a été emballée et livrée par l'artiste. Elle devrait arriver bientôt!",
            'Livré' => "L'article est arrivé a destination.",
            'En cours' => "Votre commande sera bientôt vue et traitée par l'artiste.",
            'Annulé' =>
                'Il y a eu une erreur et votre article ne peut être livré. Selon le cas, un remboursement est ou sera émis sur la carte utilisée.',
            'Panier' => "Impossible, c'est du mauvais code de la bd et les entrées panier ne doivent plus exister",
        ];

        $grandTotal = 0.0;
    @endphp

    <div class="hidden text-[#FF0000] text-[#ffb700] text-[#009b4d] text-[#0000FF] rotate-180"></div>

    <h1 class="my-8 w-full text-center titre1-dark ">Détails de la commande</h1>
    <h2 class="my-4 w-full text-center titre2-dark ">Date : {{ $commande->date }}</h2>


    @foreach ($articleParArtiste as $nomArtiste => $transactions)
        {{-- ex layout une commande --}}
        <div class="w-10/12 md:w-3/4 m-auto my-6 border-black border-2 rounded-3xl flex">
            <div class="md:w-3/4">
                @php $totalArtiste = 0.0 @endphp
                @foreach ($transactions as $transaction)
                    <div class="md:flex flex-col md:flex-row my-10 ml-6 lg:ml-24 w-full">
                        {{-- images --}}
                        <div class="w-1/2 lg:w-1/6 md:mr-4 flex relative space-x-0">
                            <img src="{{ '../img/' . $transaction->article->photo_article[0]->path }}"
                                alt="image d'article"
                                class="aspect-square object-cover rounded-[12px] shadow-xl shadow-black">
                        </div>
                        {{-- infos --}}
                        <div class="flex md:flex-col w-2/3 md:w-1/3 h-1/2 md:mx-auto justify-between flex-wrap my-4">
                            <h1 class="font-bold text-lg">{{ $transaction->article->nom }}</h1>
                            <p>{{ number_format($transaction->prix_unitaire, 2, ',', ' ') . ' $ x ' . $transaction->quantite . ' pièce(s)' }}
                            </p>

                            <div class="flex">
                                <p>Statut : <span
                                        class="text-[{{ $colors[$transaction->etat_transaction->etat] }}] underline">
                                        {{ $transaction->etat_transaction->etat }}</span></p>
                            </div>
                            <a @click=" $dispatch('open-signal-article-modal'); $dispatch('set-transaction-signal', JSON.stringify({{ $transaction }}))"
                            class="hover:underline hover:cursor-pointer w-fit text-xs">
                            @if ($transaction->etat_transaction->etat == 'Annulé')
                                Pourquoi ?
                            @else
                                Je n'ai pas reçu cet article!
                            @endif
                        </a>
                        </div>

                    {{-- prix --}}
                    <div class="w-2/3 md:w-1/3 flex md:flex-col justify-between my-4 flex-row-reverse">

                        <div class="text-3xl m-auto ">
                            <x-tooltip text="{!! $tooltips[$transaction->etat_transaction->etat] !!}" position="right"
                                id="{{ $transaction->id_transaction }}">
                                <p
                                    class="cursor-pointer hover:text-4xl {{ $transaction->etat_transaction->etat === 'Annulé' ? 'text-[#FF0000] rotate-180' : '' }}">
                                    &#9432</p>
                            </x-tooltip>
                        </div>

                    @php
                        $totalItem = $transaction->prix_unitaire * $transaction->quantite;
                        $totalArtiste += $totalItem;
                        $grandTotal += $totalItem;
                    @endphp
                    <p>Total : {{ number_format($totalItem, 2, ',', ' ') }}$</p>

            </div>
        </div>
    @endforeach
    </div>
    {{-- Colone de droite, image, nom et total artiste --}}
    <div class="flex-col flex w-1/3 md:w-1/4 justify-between mb-6">
        <div class="w-full mr-0 ml-auto">
            <img src="{{ '../' . $transactions[0]->article->artiste->path_photo_profil }}" alt="Photo de profil de l'artiste"
                class="rounded-full md:size-32 mt-4 mr-4 ml-auto">
            <p class="mr-4 ml-auto w-fit">{{ $transactions[0]->article->artiste->nom_artiste }}</p>
        </div>
        <div class="mr-4 ml-auto text-xl font-bold text-center">
            <p class="text-center">Total : {{ number_format($totalArtiste, 2, ',', ' ') }}$</p>
        </div>
    </div>
    </div>
    @endforeach

    {{-- Section a la fin, ou le total est affiché --}}
    {{-- Le total de remboursement doit être ajouté --}}
    <div class="w-3/4 m-auto my-14 flex text-center text-xl font-bold">
        <p class="w-1/4">Sous-total : {{ number_format($grandTotal, 2, ',', ' ') }} $</p>
        <p class="w-1/4">TPS : {{ number_format($grandTotal * 0.05, 2, ',', ' ') }} $</p>
        <p class="w-1/4">TVQ : {{ number_format($grandTotal * 0.09975, 2, ',', ' ') }} $</p>
        <p class="w-1/4">Total : {{ number_format($grandTotal * 1.14975, 2, ',', ' ') }} $</p>
    </div>

    @include('commande.partials.article-non-recu-modal')

    @if (Session::has('succes'))
        <div class="w-[500px] absolute right-2 bottom-10">
            @include('messages.messageSucces', [
                'message' => Session::get('succes'),
                'titre' => 'Succès',
            ])
        </div>
    @endif
    @if (Session::has('erreur'))
        <div class="w-[500px] absolute right-2 bottom-10">
            @include('messages.messageFail', [
                'message' => Session::get('erreur'),
                'titre' => 'Erreur',
            ])
        </div>
    @endif
</x-app-layout>
