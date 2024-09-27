<x-app-layout>
    <h1 class="my-8 ml-[5%] text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">Mon Panier</h1>

    {{-- Container pour diviser la page entre la liste et le résumé --}}
    <div class="flex">

        {{-- Container pour LES lignes d'articles --}}
        <div class="w-2/3 ml-[10%]">

            {{-- Une ligne d'article --}}
            @foreach ($articles as $article)

                <div class="flex m-auto my-14">
                    <img src="{{'img/'.$article->photo_article[0]->path}}" alt="Une image de pot" class="rounded-xl border shadow-xl shadow-black w-1/4 m-auto">

                    <div class="w-1/4 m-0 ml-4 flex flex-col justify-between">
                        <div class="">
                            <h2 class="text-xl font-bold"> {{$article->nom}} </h2>
                            <p>{{$article->prix}} $ / Pièce</p>
                        </div>
                        <div class="">
                            <label for="quantite">Quantité</label> </br>
                            <select name="quantite" id="quantite_" class="w-1/2">

                                @for ($i= 1; $i <= $article->quantite_disponible ; $i++)
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor

                            </select>
                        </div>
                    </div>

                    <a href="" class="w-1/4 h-full self-end underline">Supprimer l'article</a>

                    <div class="w-1/4 self-center">
                        <h3 class="self-center font-semibold">|TOTAL|</h3> {{--A updater en JS--}}
                        <img src="{{'img/'.$article->artiste->path_photo_profil}}" alt="face" class="rounded-full size-32 mt-[40%]">
                        <p>Par {{$article->artiste->nom_artiste}}</p>
                    </div>
                </div>
            @endforeach
            {{-- Test 2 eme ligne article --}}
                {{--
            <div class="flex m-auto my-2">
                <img src="{{ asset('img/tests/pot_1.jpg') }}" alt="Une image de pot" class="rounded-xl border shadow-xl shadow-black w-1/4 m-auto">

                <div class="w-1/4 m-0 ml-4">
                    <div class="">
                        <h2 class="text-xl font-bold">Pot à plante</h2>
                        <p>38.80 $ / Pièce</p>
                    </div>
                    <div class="mb-0 mt-[70%]">
                        <label for="quantite">Quantité</label> </br>
                        <select name="quantite" id="quantite_" class="w-1/2">

                            @for ($i= 1; $i <=10; $i++)
                                <option value="{{$i}}"> {{$i}} </option>
                            @endfor

                        </select>
                    </div>
                </div>

                <a href="" class="w-1/4 h-full self-end underline">Supprimer l'article</a>

                <div class="w-1/4 self-center">
                    <h3 class="self-center font-semibold">|TOTAL|</h3>
                    <img src="{{asset('img/tests/pfp.jpg')}}" alt="face" class="rounded-full size-32 mt-[40%]">
                    <p>Par Baptiste Réjean</p>
                </div>
            </div> --}}

        </div>

        {{-- Le résumé/la facture  TODO: changer la couleur--}}
        <div class="w-1/5 h-[50vh] bg-gray-200 rounded-xl sticky top-[5%] flex flex-col justify-between">
            <div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow">Sous total (n Articles) :</p>
                    <p class="">NNN $</p>
                </div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow">Frais de Livraison :</p>
                    <p class="">NNN $</p>
                </div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow">Taxes (TPS+TVQ) :</p>
                    <p class="">NNN $</p>
                </div>
            </div>

            <div class="flex w-[95%] m-auto">
                <p class="grow">Estimé total</p>
                <p class="">NNN $</p>
            </div>
            <button class="bg-[#009b4d] w-[80%] mx-auto mb-[5%] rounded-lg">Passer la commande</button>


        </div>

    </div>
</x-app-layout>
