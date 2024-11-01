
<x-app-layout>

    <h1 class="my-8 text-center titre1-dark">Commandes</h1>




    @php
        $colors = [
            'Traité' => '#0000FF',
            'Livré' => '#009b4d',
            'En cours' => '#ffb700',
            'Annulé' => '#FF0000'
        ];
    @endphp

    <div class="hidden text-[#FF0000] text-[#ffb700] text-[#009b4d] text-[#0000FF]"></div>
    {{-- Si aucune commande en cours on affiche un message, sinon on affiche les commandes--}}
    @if ($commandes == null )
        <p class="titre2-dark">Aucune commandes</p>
    @else

    <h2 class="my-8 titre2-dark m-section">En cours</h2>
        @if ($commandeEnCours == null)
        <p class="">Aucune commandes en cours</p>
        @else



            @foreach ($commandeEnCours as $commande)

                {{-- ex layout une commande --}}

                    <div class="flex my-24 ml-24">
                        {{--images--}}
                        <div class="w-1/3 flex relative space-x-0">
                            @foreach ($commande->transactions as $transaction)
                                <img src="{{'img/'. $transaction->article->photo_article[0]->path }}" alt="" class="w-1/3 h-full object-cover z-{{$loop->iteration * 10}} rounded-[12px] shadow-xl shadow-black {{$loop->first === true ? '': 'absolute left-[' . ($loop->iteration - 1)* 25 . '%]'}} ">
                                @if($loop->iteration == 3) @break @endif
                            @endforeach

                        </div>
                        {{--infos--}}
                        <div class="flex flex-col w-1/3 justify-between">
                            <p>Date : {{$commande->date}} </p>

                            @php $etat = $commande->transactions[0]->etat_transaction->etat @endphp
                            <div class="flex">
                                <p>Statut : </p><p class="text-[{{$colors[$etat]}}] underline"> {{ $etat === 'Annulé' ? ' Attention requise' : ' ' . $etat}}</p>
                            </div>

                            <a href="/commande/{{$commande->id_commande}}" class="underline hover:text-[#0000FF]">Détails</a>
                        </div>
                        {{--prix--}}
                        <div class="flex flex-col w-1/3 justify-between">
                            <a href="{{$commande->receipt_url}}">Télécharger le reçu</a>
                            @php
                                $prix = 0.0;
                                foreach ($commande->transactions as $transaction) {
                                    $prix += $transaction->prix_unitaire * $transaction->quantite;
                                }
                                $prix *= 1.15;
                            @endphp
                        <p>Total : {{number_format($prix,2,'.',' ')}} $</p>
                        </div>
                    </div>
            @endforeach
        @endif


    <h2 class="my-8 titre2-dark m-section">Précédent</h2>
        @if ($commandeFini == null)
            <p class="">Aucune commandes précédente</p>
        @else
            @foreach ($commandeFini as $commande)


                {{-- ex layout une commande --}}

                    <div class="flex my-24 ml-24">
                        {{--images--}}
                        <div class="w-1/3 flex relative space-x-0">
                            @foreach ($commande->transactions as $transaction)
                            <img src="{{'img/'. $transaction->article->photo_article[0]->path }}" alt="" class="w-1/3 h-full object-cover z-{{$loop->iteration * 10}} rounded-[12px] shadow-xl shadow-black {{$loop->first === true ? '': 'absolute left-[' . ($loop->iteration - 1)* 25 . '%]'}} ">
                            @if($loop->iteration == 3) @break @endif
                        @endforeach
                        </div>
                        {{--infos--}}
                        <div class="flex flex-col w-1/3 justify-between">
                            <p>Date : {{$commande->date}} </p>

                            @php $etat = $commande->transactions[0]->etat_transaction->etat @endphp
                            <div class="flex">
                                <p>Statut : </p><p class="text-[{{$colors[$etat]}}] underline"> {{ $etat === 'Annulé' ? ' Attention requise' : ' ' . $etat}}</p>
                            </div>

                            <a href="/commande/{{$commande->id_commande}}" class="underline hover:text-[#0000FF]">Détails</a>
                        </div>
                        {{--prix--}}
                        <div class="w-1/3 self-end">
                            @php
                                $prix = 0.0;
                                foreach ($commande->transactions as $transaction) {
                                    $prix += $transaction->prix_unitaire * $transaction->quantite;
                                }
                                $prix *= 1.15;
                            @endphp
                        <p>Total : {{number_format($prix,2,'.',' ')}} $</p>
                        </div>
                    </div>
            @endforeach
        @endif

        @endif

</x-app-layout>


