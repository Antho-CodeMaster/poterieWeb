<x-app-layout>
    <h1 class="my-8 ml-[5%] text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">Mon Panier</h1>

    {{-- Container pour diviser la page entre la liste et le résumé --}}
    <div class="flex">

        {{-- Container pour LES lignes d'articles --}}
        <div class="w-2/3 ml-[10%]">

            {{-- Une ligne d'article --}}
            @foreach ($commande->transactions as $transaction)

                <div class="flex m-auto my-14 itemPanier" data-prix="{{$transaction->article->prix}}">
                    <img src="{{'img/'.$transaction->article->photo_article[0]->path}}" alt="Une image de pot" class="rounded-xl border shadow-xl shadow-black w-1/4 m-auto">

                    <div class="w-1/4 m-0 ml-4 flex flex-col justify-between">
                        <div class="">
                            <h2 class="text-xl font-bold"> {{$transaction->article->nom}} </h2>
                            <p class="">{{$transaction->article->prix}} $ / Pièce</p>
                        </div>
                        <div class="">
                            <label for="quantite">Quantité</label> </br>
                            <select name="quantite" class="w-1/2 quantite-select quantite">

                                @for ($i= 1; $i <= $transaction->article->quantite_disponible ; $i++)
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor

                            </select>
                        </div>
                    </div>

                    <a href="" class="w-1/4 h-full self-end underline">Supprimer l'article</a>

                    <div class="w-1/4 self-center">
                        <h3 class="self-center font-semibold" id="totalArticle{{$transaction->id_transaction}}"></h3> {{--A updater en JS--}}
                        <img src="{{'img/'.$transaction->article->artiste->path_photo_profil}}" alt="face" class="rounded-full size-32 mt-[40%]">
                        <p>Par {{$transaction->article->artiste->nom_artiste}}</p>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Le résumé/la facture  TODO: changer la couleur--}}
        <div class="w-1/5 h-[50vh] bg-gray-200 rounded-xl sticky top-[5%] flex flex-col justify-between">
            <div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow" id="nb">Sous total ({{$commande->transactions->count()}} Articles) :</p>
                    <p class="" id="brut"> $</p>
                </div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow">Frais de Livraison :</p>
                    <p class="" id="frais">NNN $</p>
                </div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow">Taxes (TPS+TVQ) :</p>
                    <p class="" id="taxes">NNN $</p>
                </div>
            </div>

            <div class="flex w-[95%] m-auto">
                <p class="grow">Estimé total</p>
                <p class="" id="total">NNN $</p>
            </div>
            <button class="bg-[#009b4d] w-[80%] mx-auto mb-[5%] rounded-lg">Passer la commande</button>


        </div>

    </div>
</x-app-layout>
