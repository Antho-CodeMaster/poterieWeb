<x-app-layout>
    @php
    $colors = [
        'Traité' => '#0000FF',
        'Livré' => '#009b4d',
        'En cours' => '#ffb700',
        'Annulé' => '#FF0000',
        'Panier' => '#FF0000'
    ];
    @endphp

<div class="hidden text-[#FF0000] text-[#ffb700] text-[#009b4d] text-[#0000FF] rotate-180"></div>

    @foreach ($articleParArtiste as $nomArtiste => $transactions)
        {{-- ex layout une commande --}}
    <div class="w-3/4 m-auto border-black border-2 rounded-3xl flex">
        <div class="w-3/4">
        @php $totalArtiste = 0.0 @endphp
        @foreach ($transactions as $transaction)
            <div class="flex my-24 ml-24 w-full">
                {{--images--}}
                <div class="w-1/6 flex relative space-x-0">
                    <img src="{{'../img/' . $transaction->article->photo_article[0]->path}}" alt="image d'article" class="object-cover z-10 rounded-[12px] shadow-xl shadow-black">
                </div>
                {{--infos--}}
                <div class="flex flex-col w-1/3 h-1/2 justify-between">
                    <h1 class="font-bold text-lg">{{$transaction->article->nom}}</h1>
                    <p>{{$transaction->prix_unitaire . ' $ x ' . $transaction->quantite . ' Pièces'}}</p>

                    <div class="flex">
                        Statut : <p class="text-[{{$colors[$transaction->etat_transaction->etat]}}] underline"> {{ $transaction->etat_transaction->etat }}</p>
                    </div>

                </div>

                {{--prix--}}
                <div class="w-1/3 flex flex-col justify-between">

                        <div class="text-3xl m-auto ">
                            <x-tooltip text="TestTooltips" position="right" id="{{$transaction->id_transaction}}">
                                <p class="hover:text-4xl {{$transaction->etat_transaction->etat === "Annulé" ? "text-[#FF0000] rotate-180" : ""}}">&#9432</p>
                            </x-tooltip></div>

                    @php
                        $totalItem = $transaction->prix_unitaire * $transaction->quantite;
                        $totalArtiste += $totalItem;
                    @endphp
                    <p>Total : {{number_format($totalItem,2,'.',' ')}}</p>

                </div>
            </div>

        @endforeach
        </div>
        <div class="flex-col flex w-1/4 justify-between">
            <div class="w-full">
                <img src="{{'../img/'. $transactions[0]->article->artiste->path_photo_profil}}" alt="face" class="rounded-full size-32 mt-[40%]">
                <p>{{$transactions[0]->article->artiste->nom_artiste}}</p>
            </div>
            <div class="w-full">
                <p class="">Total : {{number_format($totalArtiste,2,'.',' ')}}</p>
            </div>
        </div>
    </div>
    @endforeach

</x-app-layout>
