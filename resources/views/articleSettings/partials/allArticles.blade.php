@if ($articles->isEmpty()) <!-- Vérifie si la collection est vide -->
    <p class="textGrand-dark m-section">Aucun article correspondant à ces filtres</p>
@else
    {{-- Affichage de tous les articles de l'artiste --}}
    <div class="rounded-[12px] m-sectionY flex flex-wrap justify-start gap-input overflow-auto relative"
        id="articlesContainer" x-data='{openDeleteArticle: false}'>
        @foreach ($articles as $article)
            @if ($article->id_etat != 3)
                <div
                    class="bg-beige rounded-[12px] w-[99%] h-[130px] flex items-center p-sectionX p-sectionY mr-2 gap-input">
                    {{-- Image de l'article --}}
                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                        class="z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[100px] w-[10%] object-cover">

                    {{-- Nom, prix et description --}}
                    <div class="w-[25%] h-full">
                        <p class="w-full articleGrand-dark whitespace-nowrap overflow-hidden">
                            {{ $article->nom }}</p>
                        <p class="w-full articlePetit-dark mt-[2px]">Prix: {{ number_format($article->prix, 2, ",", " ") }}$
                        </p>
                        <p class="w-full textPetit-dark mt-1 line-clamp-3">
                            {{ $article->description }}</p>
                        {{-- <p class="text-[14px] mt-[4px]">{{ $article->mot_cle->motCles }}</p> --}}
                    </div>

                    {{-- Dimensions et poids --}}
                    <div class="w-[17%] h-full m-sectionX">
                        {{-- Hauteur --}}
                        <div class="w-full flex items-center gap-1 h-[25%]">
                            <p class="textPetit-dark font-bold">Hauteur :</p>
                            <p class="textPetit-dark">
                                @if (Auth::user()->units == 0)
                                    {{ number_format($article->hauteur , 2, ",", " ") }} cm
                                @elseif (Auth::user()->units == 1)
                                    {{ number_format($article->hauteur / 2.54, 2, ",", " ") }} po
                                @endif
                            </p>
                        </div>

                        {{-- Largeur --}}
                        <div class="w-full flex items-center gap-1 h-[25%]">
                            <p class="textPetit-dark font-bold">Largeur :</p>
                            <p class="textPetit-dark">
                                @if (Auth::user()->units == 0)
                                    {{ number_format($article->largeur,2, ",", " ") }} cm
                                @elseif (Auth::user()->units == 1)
                                    {{ number_format($article->largeur / 2.54, 2, ",", " ") }} po
                                @endif
                            </p>
                        </div>

                        {{-- Profondeur --}}
                        <div class="w-full flex items-center gap-1 h-[25%]">
                            <p class="textPetit-dark font-bold">Profondeur :</p>
                            <p class="textPetit-dark">
                                @if (Auth::user()->units == 0)
                                    {{  number_format($article->profondeur, 2, ",", " ") }} cm
                                @elseif (Auth::user()->units == 1)
                                    {{ number_format($article->profondeur / 2.54, 2,",", " ") }} po
                                @endif
                            </p>
                        </div>
                        <div class="w-full flex items-center gap-1 h-[25%] ">
                            <p class="textPetit-dark font-bold">Poids :</p>
                            @if ($article->poids == null)
                                <p class=" textPetit-dark">N/A</p>
                            @else
                                <p class=" textPetit-dark">{{ number_format($article->poids, 2, ",", " ") }} g</p>
                            @endif

                        </div>
                    </div>

                    {{-- Type et quantité --}}
                    <div class="w-[22%] h-full flex flex-wrap gap-1">
                        <div class="w-full h-[50%] gap-1 items-baseline">
                            <div class="w-full h-[50%] items-center flex gap-input">
                                <p class="textPetit-dark font-bold">Type d'usage : </p>
                                @if ($article->is_alimentaire)
                                    <p class="textPetit-dark">Alimentaire</p>
                                @else
                                    <p class="textPetit-dark">Non alimetaire</p>
                                @endif
                            </div>
                            <div class="w-full h-[50%] items-center flex gap-input">
                                <p class="textPetit-dark font-bold">Type de pièce : </p>
                                @if ($article->is_unique)
                                    <p class="textPetit-dark">Unique</p>
                                @else
                                    <p class="textPetit-dark">En série</p>
                                @endif
                            </div>
                        </div>

                        <div class="w-full h-[45%] items-baseline flex gap-input">
                            <p class="textPetit-dark font-bold">Quantité : </p>
                            @if ($article->quantite_disponible < 1)
                                <p class="textPetit-dark ">En rupture de stock</p>
                            @elseif ($article->quantite_disponible >= 1)
                                <p class="textPetit-dark ">{{ $article->quantite_disponible }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Masqué, floutter, en vedette --}}
                    <div class="w-[11%] m-sectionX h-full">
                        <div class="w-full h-[30%] flex items-start justify-between">
                            <p class="textGrand-dark font-bold">Masqué</p>
                            @if ($article->id_etat == 1)
                                <span class=" border-2 border-darkGrey p-2 rounded-[99px]">

                                </span>
                            @elseif($article->id_etat == 2)
                                <span class=" bg-darkGrey border-2 border-darkGrey p-2 rounded-[99px]">

                                </span>
                            @endif
                        </div>

                        <div class="w-full h-[40%] flex items-center justify-between border-y-[1px] border-darkGrey">
                            <!-- En vedette -->
                            <p class="textGrand-dark font-bold">En vedette</p>
                            @if ($article->is_en_vedette == 1)
                                <span class="bg-darkGrey border-2 border-darkGrey p-2 rounded-[99px]">

                                </span>
                            @elseif($article->is_en_vedette == 0)
                                <span class=" border-2 border-darkGrey p-2 rounded-[99px]">

                                </span>
                            @endif
                        </div>

                        <div class="w-full h-[30%] flex items-end justify-between">
                            <!-- Sensible -->
                            <p class="textGrand-dark font-bold">Sensible</p>
                            @if ($article->is_sensible == 1)
                                <span class="bg-darkGrey border-2 border-darkGrey p-2 rounded-[99px]">

                                </span>
                            @elseif($article->is_sensible == 0)
                                <span class=" border-2 border-darkGrey p-2 rounded-[99px]">

                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="w-[5%] h-full flex flex-wrap items-center justify-center">

                        {{-- Lien vers modifArticle --}}
                        <form action="{{ route('modifArticleForm', ['idArticle' => $article->id_article]) }}"
                            class="w-full h-[50%] flex items-center justify-center" method="get">
                            @csrf
                            <button type="submit" class="w-full h-full flex items-center">
                                <svg class="w-full h-full text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#444444"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>

                        {{-- Bouton pour supprimer l'article --}}
                        <div class="w-full h-[50%] flex items-center justify-center" x-data="{ openDeleteArticle: false }">
                            <button
                                @click=" $dispatch('open-delete-article-modal');
                          $dispatch('set-id', {{ $article->id_article }});">
                                <svg class="w-full h-full text-blue-900 hover:text-red-600" width="40"
                                    height="44" viewBox="0 0 40 44" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 10H6M6 10H38M6 10V38C6 39.0609 6.42143 40.0783 7.17157 40.8284C7.92172 41.5786 8.93913 42 10 42H30C31.0609 42 32.0783 41.5786 32.8284 40.8284C33.5786 40.0783 34 39.0609 34 38V10M12 10V6C12 4.93913 12.4214 3.92172 13.1716 3.17157C13.9217 2.42143 14.9391 2 16 2H24C25.0609 2 26.0783 2.42143 26.8284 3.17157C27.5786 3.92172 28 4.93913 28 6V10M16 20V32M24 20V32"
                                        stroke="#FC6262" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                        class="" />
                                </svg>
                            </button>
                        </div>
                        @include('kiosque.deleteArticle-modal')
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Artiste inactif --}}
        @if (Session::has('errorInactif'))
            <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
                @include('messages.messageFail', [
                    'message' => Session::get('errorInactif'),
                    'titre' => 'Artiste pas trouvée',
                ])
            </div>
        @endif
    </div>
@endif
