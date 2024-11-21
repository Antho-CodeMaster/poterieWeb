<x-app-layout>
    <h1 class="titre1-dark text-center mt-6 mb-12
    ">Mon Panier</h1>
    {{-- Container pour diviser la page entre la liste et le résumé --}}
    <div class="lg:flex mb-12 px-2 md:px-10">
        {{-- Container pour LES lignes d'articles --}}
        <div class="w-full lg:w-8/12 flex flex-col gap-8 md:px-10">
            {{-- Une ligne d'article --}}
            @foreach ($commande->transactions as $transaction)
                <div class="flex itemPanier w-full h-[200px]"
                    data-prix="{{ $transaction->article->prix }}" data-ida="{{ $transaction->article->id_article }}"
                    data-idt="{{ $transaction->id_transaction }}">
                    <div class="w-[200px] self-center ml-2">
                        <img src="{{ 'img/' . $transaction->article->photo_article[0]->path }}" alt="Une image de pot"
                            class="rounded-xl border shadow-xl shadow-black m-auto aspect-square object-cover">
                    </div>
                    <div class="w-1/2 md:w-1/4 m-1 flex flex-col justify-around">
                        <div class="">
                            <h2 class="textGrand-dark"> {{ $transaction->article->nom }} </h2>
                            <p class="">{{ $transaction->article->prix }} $ / pièce</p>
                        </div>
                        <div class="">
                            <label for="quantite">Quantité</label> </br>
                            <select name="quantite" class="w-1/2 quantite-select quantite">

                                @for ($i = 1; $i <= $transaction->article->quantite_disponible; $i++)
                                    <option value="{{ $i }}"
                                        {{ $i === $transaction->quantite ? 'selected' : '' }}> {{ $i }}
                                    </option>
                                @endfor

                            </select>
                        </div>
                    </div>

                    <!-- Pho artiste et nom-->

                    <div class="h-1/3 md:h-full w-2/12 flex flex-col self-center">
                        <div class="m-auto">
                            <img src="{{ $transaction->article->artiste->path_photo_profil }}"
                                alt="Photo de profil de l'artiste" class="rounded-full ">
                            <p class="text-center">{{ $transaction->article->artiste->nom_artiste }}</p>
                        </div>
                    </div>

                    <!-- Boutton effacer -->
                    <div class="h-1/3 w-1/4 md:h-full flex flex-col self-center underline">
                        <a class="m-auto"
                            @auth
                                href="{{ route('removeFromPanier', ['id' => $transaction->id_transaction]) }}" @endauth
                            @guest
                                href="{{ route('removeFromPanier', ['id' => $transaction->id_article]) }}" @endguest>
                            <svg width="40" height="44" viewBox="0 0 40 44" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 10H6M6 10H38M6 10V38C6 39.0609 6.42143 40.0783 7.17157 40.8284C7.92172 41.5786 8.93913 42 10 42H30C31.0609 42 32.0783 41.5786 32.8284 40.8284C33.5786 40.0783 34 39.0609 34 38V10M12 10V6C12 4.93913 12.4214 3.92172 13.1716 3.17157C13.9217 2.42143 14.9391 2 16 2H24C25.0609 2 26.0783 2.42143 26.8284 3.17157C27.5786 3.92172 28 4.93913 28 6V10M16 20V32M24 20V32"
                                    stroke="#FF0000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Le résumé/la facture  TODO: changer la couleur --}}
        <div class="w-full lg:w-4/12 ">
            <div x-data
                class="w-3/4 mx-auto h-fit bg-gray-200 rounded-xl sticky top-[10%] flex flex-col justify-between">
                <div class="m-section">
                    <div class="flex mx-auto">
                        <p class="grow textMoyen-dark" id="nb">Total des articles</p>
                        <p class="textMoyen-dark" id="brut"> $</p>
                    </div>
                    <div class="flex mx-auto m-sectionY">
                        <p class="grow textMoyen-dark">Frais de livraison estimés</p>
                        <p class="textMoyen-dark" id="frais">NNN $</p>
                    </div>
                    <div class="flex mx-auto">
                        <p class="grow textMoyen-dark">Taxes (TPS + TVQ) estimées</p>
                        <p class="textMoyen-dark" id="taxes">NNN $</p>
                    </div>
                </div>

                <div class="flex m-section border-t-2 border-darkGrey p-sectionTop">
                    <p class="grow textMoyen-dark">Total estimé</p>
                    <p class="textMoyen-dark font-bold" id="total">NNN $</p>
                </div>

                <div class="m-sectionY">
                    @auth
                        @if (!$commande->transactions->isEmpty())
                            <form class="w-full" action="{{ route('checkout') }}">
                                <x-button.green.pay class="w-[80%] mx-auto mb-[5%] rounded-lg">Passer la
                                    commande</x-button.green.pay>
                                    <p class="w-4/5 mx-auto text-center italic">Le paiement sera effectué avec Stripe, une application tierce-partie qui assure que vos données seront sécurisées.</p>
                            </form>
                        @else
                            <form class="w-full flex items-center" action="{{ route('decouverte') }}">
                                <x-button.border.empty class="w-[80%] mx-auto mb-[5%] rounded-lg"> Remplir le
                                    panier</x-button.border.empty>
                            </form>
                        @endif
                    @endauth
                    @guest
                        <x-button.border.empty class="w-[80%] mx-auto mb-[5%] rounded-lg" @click="$dispatch('open-login-modal')">
                            Se connecter pour payer la commande
                        </x-button.border.empty>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
