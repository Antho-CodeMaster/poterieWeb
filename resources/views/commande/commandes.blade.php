<x-app-layout>
    <h1 class="my-8 mx-auto text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">Commandes</h1>

    {{-- ex layout une commande --}}
    <div class="flex my-auto">
        {{--images--}}
        <div class="w-1/3 flex relative space-x-0 -ml-4">
            <img src="img/tests/pot_1.jpg" alt="" class="w-full h-full object-cover z-10">
            <img src="img/tests/pot_2.jpg" alt="" class="w-4 h-4 object-cover z-20 -ml-4">
            <img src="img/tests/pot_3.jpg" alt="" class="w-4 h-4 object-cover z-30 -ml-4">

        </div>
        {{--infos--}}
        <div class="flex flex-col w-1/3">
            <p>Date : bonne fete</p>
            <div>
                Statut : <p class="text-[#ffb700] underline">En attente</p>
            </div>
            <a href="" class="underline">Détails</a>
        </div>
        {{--prix--}}
        <div class="w-1/3 self-end">
            prix
        </div>
    </div>
</x-app-layout>
