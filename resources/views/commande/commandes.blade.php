
<x-app-layout>

    <h1 class="my-8 mx-auto text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">Commandes</h1>


    <h2 class="my-8 mx-auto text-l font-bold leading-none tracking-tight md:text-4xl lg:text-4xl">En cours</h2>
    {{-- Si aucune commande en cours on affiche un message, sinon on affiche les commandes--}}
    @if ($commandes->count() == 0)
        <p class="">Aucune commandes en cours</p>
    @else

        {{-- ex layout une commande --}}

            <div class="flex my-auto ml-24">
                {{--images--}}
                <div class="w-1/3 flex relative space-x-0">
                   {{--<img src="{{'img/'. $commandes->articles[0]->photo_article }}" alt="" class="w-1/3 h-full object-cover z-10 rounded-[12px] shadow-xl shadow-black">
                    <img src="{{'img/'. $commandes->articles[1]->photo_article }}" alt="" class="w-1/3 h-full object-cover z-20 absolute left-[25%] rounded-[12px] shadow-xl shadow-black">
                    <img src="{{'img/'. $commandes->articles[2]->photo_article }}" alt="" class="w-1/3 h-full object-cover z-30 absolute left-[50%] rounded-[12px] shadow-xl shadow-black">
--}}
                </div>
                {{--infos--}}
                <div class="flex flex-col w-1/3 justify-between">
                    <p>Date : {{$commandes[0]->date}} </p>
                    <div class="flex">
                        Statut : <p class="text-[#ffb700] underline"> {{--$commandes[0]->transactions[0]->etat_transaction--}}</p>
                    </div>
                    <div class="underline" @click="openModal({{$commandes[0]->id}})">Détails</div>
                </div>
                {{--prix--}}
                <div class="w-1/3 self-end">
                    prix
                </div>
            </div>

    @endif


    <h2 class="my-8 mx-auto text-l font-bold leading-none tracking-tight md:text-4xl lg:text-4xl">Précédent</h2>
    <div class="flex my-auto ml-24">
        {{--images--}}
        <div class="w-1/3 flex relative space-x-0">
            <img src="img/tests/pot_1.jpg" alt="" class="w-1/3 h-full object-cover z-10 rounded-[12px] shadow-xl shadow-black">
            <img src="img/tests/pot_2.jpg" alt="" class="w-1/3 h-full object-cover z-20 absolute left-[25%] rounded-[12px] shadow-xl shadow-black">
            <img src="img/tests/pot_3.jpg" alt="" class="w-1/3 h-full object-cover z-30 absolute left-[50%] rounded-[12px] shadow-xl shadow-black">

        </div>
        {{--infos--}}
        <div class="flex flex-col w-1/3 justify-between">
            <p>Date : bonne fete</p>
            <div class="flex">
                Statut : <p class="text-[#ffb700] underline">En attente</p>
            </div>
            <!-- Trigger Button for Login Modal -->
            <button @click="openCommande = true">
                <div class="">
                    Détail
                </div>
            </button>
        </div>
        {{--prix--}}
        <div class="w-1/3 self-end">
            prix
        </div>
    </div>
    @dump($commandes)
    {{$name = $commandes[0]->date}}
    <div x-data="{ open: false }">

        <!-- Include Login & Register Modal -->
        @include('commande.components.detail-commande-modal')
    </div>
</x-app-layout>
