<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col">
            <h1 class=" m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Tous mes articles</h1>

            {{-- Filtres de recherche --}}
            <form action="" method="post" class="flex justify-between">

                <!-- Barre de recherche -->
                <div id="search-article" class="w-[300px] h-[40px] flex border rounded border-darkGrey">
                    <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                        placeholder="Rechercher par nom..." name="search">
                    <button>
                        <svg class="w-6 h-6 mr-3 text-darkGrey dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </div>

                <div class="flex gap-6">
                    {{-- Filtre prix --}}
                    <div class="flex gap-2 items-center w-[300px] h-[40px]">
                        <div>
                            <p id="min-Value" class="font-medium w-[50px] whitespace-nowrap text-right">$ 0</p>
                        </div>

                        <div class="rangeSlider flex items-center">

                            <div class="rangeFill">

                            </div>

                            <input type="range" name="" id="" class="slider" value="100"
                                min="0" max="1000" step="10">
                            <input type="range" name="" id="" class="slider" value="300"
                                min="0" max="1000" step="10">
                        </div>

                        <div>
                            <p id="max-Value" class="font-medium w-[50px] whitespace-nowrap">$ 999</p>
                        </div>
                    </div>

                    {{-- Filtre type d'usage --}}
                    <select id="typePieceFiltre" name="typePieceFiltre" required
                        class="h-[40px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="" disabled selected hidden>Type d'usage
                        </option>
                        <option value="1">Alimentaire</option>
                        <option value="0">Non-alimentaire</option>
                    </select>

                    {{-- Filtre type de pièce --}}
                    <select id="pieceUniqueFiltre" name="pieceUniqueFiltre"
                        class="h-[40px] w-[160px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="" disabled selected hidden>Type de pièce
                        </option>
                        <option value="1">Unique</option>
                        <option value="0">En série</option>
                    </select>
                </div>
            </form>

            {{-- Affichage de tous les articles de l'artiste --}}
            <div class="rounded-[12px] m-sectionY flex flex-wrap gap-input overflow-auto">
                @foreach ($articles as $article)
                    @if ($article->id_etat != 3)
                        <div class="bg-beige rounded-[12px] w-full h-[130px] flex items-center p-sectionX p-sectionY mr-2">
                            {{-- Image de l'article --}}
                            <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[100px] w-[100px] object-cover">

                            {{-- Nom, prix et description --}}
                            <div class="w-[400px] h-[100px] mx-[5px]">
                                <p class=" articleGrand-dark whitespace-nowrap overflow-hidden">{{ $article->nom }}</p>
                                <p class=" articlePetit-dark mt-[2px]">Prix: {{ $article->prix }}$
                                </p>
                                <p class="textPetit-dark mt-1 text-ellipsis overflow-y-hidden ">{{ $article->description }}</p>
                                {{-- <p class="text-[14px] mt-[4px]">{{ $article->mot_cle->motCles }}</p> --}}
                            </div>

                            {{-- Dimensions et poids --}}
                            <div class="w-[180px] h-[100px] m-sectionX">
                                <div class="flex items-center gap-1 h-[25%]">
                                    <p class="textPetit-dark font-bold">Hauteur:</p>
                                    <p class="textPetit-dark">{{ $article->hauteur }} cm</p>
                                </div>
                                <div class="flex items-center gap-1 h-[25%]">
                                    <p class="textPetit-dark font-bold">Largeur:</p>
                                    <p class="textPetit-dark">{{ $article->largeur }} cm</p>
                                </div>
                                <div class="flex items-center gap-1 h-[25%]">
                                    <p class="textPetit-dark font-bold">Profondeur:</p>
                                    <p class="textPetit-dark">{{ $article->profondeur }} cm</p>
                                </div>
                                <div class="flex items-center gap-1 h-[25%] ">
                                    <p class="textPetit-dark font-bold">Poids:</p>
                                    <p class=" textPetit-dark">{{ $article->poids }} cm</p>
                                </div>
                            </div>

                            {{-- Type et quantité --}}
                            <div class="h-[100px] flex flex-wrap w-[275px]">
                                <div class="flex flex-wrap gap-1">
                                    <div class="flex gap-input">
                                        <p class="textPetit-dark font-bold">Type d'usage: </p>
                                        @if ($article->is_alimentaire)
                                            <p class="textPetit-dark">Alimetaire</p>
                                        @else
                                            <p class="textPetit-dark">Non-alimetaire</p>
                                        @endif
                                    </div>
                                    <div class="flex gap-input">
                                        <p class="textPetit-dark font-bold">Type de pièce: </p>
                                        @if ($article->is_unique)
                                            <p class="textPetit-dark">Unique</p>
                                        @else
                                            <p class="textPetit-dark">En série</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex gap-1 text-end w-full">
                                    <p class="text-[16px] font-semibold mb-0 mt-auto">Quantité: </p>
                                    @if ($article->quantite_disponible < 1)
                                        <p class="text-[14px] mb-0 mt-auto">En rupture de stock</p>
                                    @elseif ($article->quantite_disponible >= 1)
                                        <p class="text-[14px] mb-0 mt-auto">{{ $article->quantite_disponible }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Masqué, floutter, en vedette A DEBUGGUER --}}
                            <div class=" m-sectionX">
                                @if ($article->id_etat == 1)
                                    <p
                                        class="border border-darkGrey articleGrand-dark px-[10px] py-[3px] bg-white">
                                        Visible</p>
                                @elseif($article->id_etat == 2)
                                    <p
                                        class="border border-darkGrey articleGrand-light px-[10px] py-[3px] bg-darkGrey">
                                        Masqué</p>
                                @endif

                                @if ($article->is_en_vedette == 1)
                                    <p
                                        class="border border-darkGrey articleGrand-dark px-[10px] py-[3px] bg-white">
                                        En vedette</p>
                                @elseif($article->is_en_vedette == 0)
                                    <p
                                        class="border border-darkGrey articleGrand-light px-[10px] py-[3px] bg-darkGrey">
                                        En vedette</p>
                                @endif

                                @if ($article->is_sensible == 1)
                                    <p
                                        class="border border-darkGrey articleGrand-dark px-[10px] py-[3px] bg-white">
                                        Sensible</p>
                                @elseif($article->is_sensible == 0)
                                    <p
                                        class="border border-darkGrey articleGrand-light px-[10px] py-[3px] bg-darkGrey">
                                        Sensible</p>
                                @endif
                            </div>

                            {{-- Montré le nombre de like --}}
                            <form action="{{ route('modifArticleForm', ['idArticle' => $article->id_article]) }}" method="get">
                                @csrf
                                <button type="submit">
                                    <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="#444444" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
