<x-app-layout>

    {{-- Section Bannière --}}
    <section class="flex items-center justify-between p-[16px]" {{-- style="background-color: #{{ $artiste->couleur_banniere }}" --}}>

        {{-- Nom d'artiste --}}
        <div class="flex-1 text-left reseaux">
            {{ $artiste->nom_artiste }}
        </div>

        {{-- Photo de profil --}}
        <div class="flex-shrink-0 mx-auto ">
            <img src="img/{{ $artiste->path_photo_profil }}" alt="photo de profil"
                class="w-[150px] h-[150px] rounded-[100px]">
        </div>

        {{-- Réseaux sociaux --}}
        <div class="flex-1 felx-shrink">
            @foreach ($reseaux as $reseau)
                <div class="text-right">
                    <a href="{{ $reseau->url }}{{ $reseau->pivot->username }}" class="inline-flex items-center">
                        <p class="reseaux">{{ $reseau->pivot->username }}</p>

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'YouTube')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Instagram')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Facebook')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section En vedette --}}
    <section class="mt-[32px]">
        <h2 class="titre2 mx-[16px]">En vedette</h2>
        <div class="bg-beige flex items-center justify-between realtive">

            {{-- Flèche gauche --}}
            <svg id="prevBtn" class="text-darkGrey absolute cursor-pointer z-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 19-7-7 7-7" />
            </svg>


            <div id="carousel" class="flex overflow-x-scroll scroll-smooth whitespace-nowrap scrollbar-hide w-full">
                {{-- Affiche seulement les articles visibles, en stock et en vedette seulement --}}
                @foreach ($articles as $article)
                    @if ($article->etat->etat == 'Visible client' && $article->quantite_disponible > 0 && $article->is_en_vedette == 1)
                        <div class="w-[300px] m-[16px] flex-shrink-0 overflow-hidden whitespace-nowrap">
                            <img src="img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="shadow-md rounded-[16px] cursor-pointer">
                            <div class="flex justify-between items-center my-[10px]">
                                <div class="w-[80%]">
                                    <p class="article mb-[3px]">{{ $article->nom }}</p>
                                    <p id="prix" class="text-[15px] font-bold text-darkGrey">{{ $article->prix }}$
                                    </p>
                                </div>

                                {{-- Vérifie chaque like du user avec l'article --}}
                                @if ($article->isLikedByUser(Auth::id()))
                                    <svg class="w-10 h-10 text-darkGery" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ff0000"
                                        viewBox="0 0 24 24">
                                        <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                                    </svg>
                                @else
                                    <svg class="w-10 h-10 text-gray-800 dark:text-white mb-[2px]" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                    </svg>
                                @endif
                            </div>
                            <form action="{{ route('decouverte') }}" method="GET">
                                <button type="submit" value="add" name="ajouterPanier"
                                    class="border-darkGrey border rounded-[24px] w-[100%] h-[40px] article">Ajouter au
                                    panier
                                </button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>


            {{-- Flèche droite --}}

            <svg id="nextBtn" class="text-darkGrey absolute right-0 cursor-pointer z-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m9 5 7 7-7 7" />
            </svg>

        </div>
    </section>

    {{-- Section Tous les articles --}}
    <section class="mt-[32px]">
        <div class="flex justify-between items-center">
            <div class="flex">
                <h2 class="titre2 ml-[16px] mr-[2px]">Tous les articles</h2>
                <svg class="w-8 h-8 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                    <path
                        d="M10.83 5a3.001 3.001 0 0 0-5.66 0H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17ZM4 11h9.17a3.001 3.001 0 0 1 5.66 0H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2Zm1.17 6H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17a3.001 3.001 0 0 0-5.66 0Z" />
                </svg>
            </div>

            {{-- Boutons d'artistes --}}

            {{-- Vérification si l'utilisateur qui visite la page est le propriétaire du kiosque --}}
            @if (Auth::user()->id == $artiste->id_user)
                <div x-data="{ open: false }">
                    @include('components.addArticle-modal')
                </div>
            @endif
        </div>
        <div class="bg-beige flex flex-wrap justify-between">

            {{-- Affichage de tous les articles --}}
            @if ($article->etat->etat == 'Visible client' || $article->etat->etat == 'Masqué client')
                @foreach ($articles as $article)
                    <div class="w-[160px] mx-[16px] my-[16px] whitespace-nowrap">

                        {{-- Changer l'image selon l'état de l'article --}}
                        @if ($article->id_etat == 2)
                            <img src="img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%]">
                        @elseif ($article->quantite_disponible = 0 && $article->id_etat == 1)
                            <img src="img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%]">
                        @else
                            <img src="img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="shadow-md shadow-rounded rounded-[12px] cursor-pointer">
                        @endif

                        <div class="flex justify-between items-center my-[4px]">
                            <div class="w-[80%]">
                                <p class="smallArticle">{{ $article->nom }}</p>
                                <p class="text-[11px] font-bold text-darkGrey ">{{ $article->prix }}$
                                </p>
                            </div>

                            {{-- Vérifie chaque like du user avec l'article --}}
                            @if ($article->isLikedByUser(Auth::id()))
                                <svg class="w-10 h-10 text-darkGery" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ff0000"
                                    viewBox="0 0 24 24">
                                    <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                                </svg>
                            @else
                                <svg class="w-10 h-10 text-gray-800 dark:text-white mb-[2px]" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                </svg>
                            @endif
                        </div>

                        {{-- Changer le bouton selon l'état de l'article --}}
                        @if ($article->id_etat == 2)
                            <p
                                class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] text-beige font-bold bg-darkGrey text-center">
                                Masqué</p>
                        @else
                            @if ($article->quantite_disponible = 0)
                                <p
                                    class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] text-beige font-bold bg-darkGrey text-center">
                                    En rupture de stock</p>
                            @endif
                            <form action="{{ route('decouverte') }}" method="GET">
                                <button type="submit" value="add" name="ajouterPanier"
                                    class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] text-darkGrey font-bold">Ajouter
                                    au
                                    panier</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </section>
</x-app-layout>

{{-- TODO: La partie responsive --}}
