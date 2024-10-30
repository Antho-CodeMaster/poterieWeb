<x-app-layout>
    <h1 class="my-8 ml-[5%] text-4xl leading-none tracking-tight md:text-5xl lg:text-6xl">Mon Panier</h1>

    {{-- Container pour diviser la page entre la liste et le résumé --}}
    <div class="flex">



        {{-- Container pour LES lignes d'articles --}}
        <div class="w-2/3 ml-[10%]">


            {{-- Une ligne d'article --}}
            @foreach ($commande->transactions as $transaction)

                <div class="flex m-auto my-14 itemPanier" data-prix="{{$transaction->article->prix}}">
                    <img src="{{'img/'.$transaction->article->photo_article[0]->path}}" alt="Une image de pot" class="rounded-xl border shadow-xl shadow-black w-1/4 m-auto aspect-square">

                    <div class="w-1/4 m-0 ml-4 flex flex-col justify-between">
                        <div class="">
                            <h2 class="text-xl font-bold"> {{$transaction->article->nom}} </h2>
                            <p class="">{{$transaction->article->prix}} $ / Pièce</p>
                        </div>
                        <div class="">
                            <label for="quantite">Quantité</label> </br>
                            <select name="quantite" class="w-1/2 quantite-select quantite">

                                @for ($i= 1; $i <= $transaction->article->quantite_disponible ; $i++)
                                    <option value="{{$i}}" {{$i === $transaction->quantite ? 'selected' : ''}}> {{$i}} </option>
                                @endfor

                            </select>
                        </div>
                    </div>

                    <div class="w-1/4 self-center">
                        <h3 class="self-center font-semibold" id="totalArticle{{$transaction->id_transaction}}"></h3> {{--A updater en JS--}}
                        <img src="{{$transaction->article->artiste->path_photo_profil}}" alt="face" class="rounded-full size-32 mt-[40%]">
                        <p>Par {{$transaction->article->artiste->nom_artiste}}</p>
                    </div>

                    <a href="/deleteThisArticle/{{$transaction->id_transaction}}" class="w-1/4 h-full self-center underline">
                    <svg width="40" height="44" viewBox="0 0 40 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10H6M6 10H38M6 10V38C6 39.0609 6.42143 40.0783 7.17157 40.8284C7.92172 41.5786 8.93913 42 10 42H30C31.0609 42 32.0783 41.5786 32.8284 40.8284C33.5786 40.0783 34 39.0609 34 38V10M12 10V6C12 4.93913 12.4214 3.92172 13.1716 3.17157C13.9217 2.42143 14.9391 2 16 2H24C25.0609 2 26.0783 2.42143 26.8284 3.17157C27.5786 3.92172 28 4.93913 28 6V10M16 20V32M24 20V32" stroke="#808080" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            @endforeach

        </div>

        {{-- Le résumé/la facture  TODO: changer la couleur--}}
        <div class="w-1/5 h-[50vh] bg-gray-200 rounded-xl sticky top-[5%] flex flex-col justify-between">
            <div>
                <div class="flex w-[95%] m-auto">
                    <p class="grow" id="nb">Sous total ( Articles) :</p>
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
            @if (Auth::check())
                <a><button class="bg-[#009b4d] w-[80%] mx-auto mb-[5%] rounded-lg">Passer la commande</div></a>
            @else
                <div x-data>
                    <button class="bg-[#009b4d] w-[80%] mx-auto mb-[5%] rounded-lg" @click="$dispatch('open-login-modal')">
                        Passer la commande
                    </button>
                </div>
            @endif



        </div>

    </div>
</x-app-layout>
