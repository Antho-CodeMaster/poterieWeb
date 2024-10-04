
<x-app-layout>

    <h1 class="my-8 mx-auto text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">Commandes</h1>


    <h2 class="my-8 mx-auto text-l font-bold leading-none tracking-tight md:text-4xl lg:text-4xl">En cours</h2>
    {{-- Si aucune commande en cours on affiche un message, sinon on affiche les commandes--}}

    @php
        $colors = [
            'Traité' => '#0000FF',
            'Livré' => '#009b4d',
            'En cours' => '#ffb700',
            'Annulé' => '#FF0000'
        ];
    @endphp

    <div class="hidden text-[#FF0000] text-[#ffb700] text-[#009b4d] text-[#0000FF]"></div>

    @if ($commandes == null )
        <p class="">Aucune commandes en cours</p>
    @else
        @foreach ($commandes as $commande)


            {{-- ex layout une commande --}}

                <div class="flex my-24 ml-24">
                    {{--images--}}
                    <div class="w-1/3 flex relative space-x-0">
                        <img src="{{'img/'. $commande->transactions[0]->article->photo_article[0]->path }}" alt="" class="w-1/3 h-full object-cover z-10 rounded-[12px] shadow-xl shadow-black">
                        <img src="{{'img/'. $commande->transactions[1]->article->photo_article[0]->path }}" alt="" class="w-1/3 h-full object-cover z-20 absolute left-[25%] rounded-[12px] shadow-xl shadow-black">
                        <img src="{{'img/'. $commande->transactions[2]->article->photo_article[0]->path }}" alt="" class="w-1/3 h-full object-cover z-30 absolute left-[50%] rounded-[12px] shadow-xl shadow-black">
                    </div>
                    {{--infos--}}
                    <div class="flex flex-col w-1/3 justify-between">
                        <p>Date : {{$commande->date}} </p>

                        <div class="flex">
                            Statut : <p class="text-[{{$colors[$commande->transactions[0]->etat_transaction->etat]}}] underline"> {{$commande->transactions[0]->etat_transaction->etat}}</p>
                        </div>

                        <a href="/commande/{{$commande->id_commande}}" class="underline">Détails</a>
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
                       Total : {{number_format($prix,2,'.',' ')}}$
                    </div>
                </div>
            @endforeach
    @endif


    <h2 class="my-8 mx-auto text-l font-bold leading-none tracking-tight md:text-4xl lg:text-4xl">Précédent</h2>

    @dump($commandes)
</x-app-layout>


