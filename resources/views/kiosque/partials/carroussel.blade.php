<div class="bg-beige flex items-center justify-between relative">

    {{-- Flèche gauche --}}
    <svg id="prevBtn"
        class="text-darkGrey absolute cursor-pointer z-[10] transition-transform duration-200 transform hover:scale-[115%]"
        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none"
        viewBox="4 4 16 16">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
    </svg>


    <div id="carousel" class="flex overflow-x-scroll scroll-smooth whitespace-nowrap scrollbar-hide w-full ">
        {{-- Affiche seulement les articles visibles, en stock et en vedette seulement --}}
        @foreach ($articles as $article)
            @if ($article->etat->etat == 'Visible client' && $article->quantite_disponible > 0 && $article->is_en_vedette == 1)
                {{-- Div de l'article --}}
                <div class="w-[300px] m-article flex-shrink-0  whitespace-nowrap " x-data="{ openArticleModal: false, currentIndex: 0 }">
                    <div
                        class="relative overflow-hidden transition-all ease-in-out duration-200 hover:scale-[103%] hover:shadow-md rounded-[16px]">
                        @if (Auth::check())
                            @if (Auth::user()->contenu_sensible == 1)
                                <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                    class="shadow-md rounded-[16px] cursor-pointer w-full h-[300px] object-cover select-none"
                                    @click=" $dispatch('open-article-modal');
                                    $dispatch('set-article', {
                                        id_article: '{{ $article->id_article }}',
                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                        id_etat: '{{ $article->id_etat }}',
                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                        description: '{{ htmlspecialchars($article->description) }}',
                                        prix: '{{ number_format($article->prix, 2, ",", " ") }}',
                                        hauteur: '{{ number_format( $article->hauteur, 2, ",", " ") }}',
                                        largeur: '{{ number_format($article->largeur,2, ",", " ") }}',
                                        profondeur: '{{ number_format($article->profondeur, 2, ",", " ") }}',
                                        poids: '{{ $article->poids }}',
                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                        is_unique: '{{ $article->is_unique }}',
                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                        is_sensible: '{{ $article->is_sensible }}',
                                    });
                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                            @else
                                <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                    class="shadow-md rounded-[16px] cursor-pointer w-full h-[300px] object-cover  select-none {{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }}"
                                    @click=" $dispatch('open-article-modal');
                                    $dispatch('set-article', {
                                        id_article: '{{ $article->id_article }}',
                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                        id_etat: '{{ $article->id_etat }}',
                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                        description: '{{ htmlspecialchars($article->description) }}',
                                        prix: '{{ number_format($article->prix, 2, ",", " ") }}',
                                        hauteur: '{{ number_format($article->hauteur , 2, ",", " ") }}',
                                        largeur: '{{ number_format($article->largeur,2, ",", " ") }}',
                                        profondeur: '{{ number_format($article->profondeur, 2, ",", " ") }}',
                                        poids: '{{ $article->poids }}',
                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                        is_unique: '{{ $article->is_unique }}',
                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                        is_sensible: '{{ $article->is_sensible }}',
                                    });
                                     $dispatch('set-artiste', '{{ $article->artiste }}');
                                     $dispatch('set-photos', '{{ $article->photo_article }}');
                                     $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                            @endif
                        @else
                            <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="shadow-md rounded-[16px] cursor-pointer w-full h-[300px] object-cover  select-none {{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }}"
                                @click=" $dispatch('open-article-modal');
                                $dispatch('set-article', {
                                    id_article: '{{ $article->id_article }}',
                                    id_artiste: '{{ $article->artiste->id_artiste }}',
                                    id_etat: '{{ $article->id_etat }}',
                                    nom: '{{ htmlspecialchars($article->nom) }}',
                                    description: '{{ htmlspecialchars($article->description) }}',
                                    prix: '{{ number_format($article->prix, 2, ",", " ") }}',
                                    hauteur: '{{ number_format($article->hauteur , 2, ",", " ") }}',
                                    largeur: '{{ number_format($article->largeur,2, ",", " ") }}',
                                    profondeur: '{{ number_format($article->profondeur, 2, ",", " ") }}',
                                    poids: '{{ $article->poids }}',
                                    quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                    is_unique: '{{ $article->is_unique }}',
                                    is_alimentaire: '{{ $article->is_alimentaire }}',
                                    is_sensible: '{{ $article->is_sensible }}',
                                });
                                 $dispatch('set-artiste', '{{ $article->artiste }}');
                                 $dispatch('set-photos', '{{ $article->photo_article }}');
                                 $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                        @endif
                    </div>

                    <div class="flex justify-between items-center my-[10px]">
                        <div class="w-[80%]">
                            <p class=" articleGrand-dark ">{{ $article->nom }}</p>
                            <p id="prix" class="articlePetit-dark">{{ number_format($article->prix, 2, ",", " ") }}$
                            </p>
                        </div>

                        {{-- Vérifie chaque like du user avec l'article --}}
                        @auth
                            <div x-cloak x-data="{ liked: {{ json_encode($article->isLikedByUser(Auth::id()) != '' ? true : false) }} }"
                                @click="toggleLike({{ $article->id_article }}); liked = !liked"
                                class="relative cursor-pointer flex items-center justify-center">

                                <svg class="w-14 h-14 mb-[2px] relative z-20 transition-all duration-200"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        class="main fill-transparent stroke-darkGrey stroke-2 origin-center transition-transform duration-300"
                                        :class="liked ? 'scale-0' : 'scale-100'"
                                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                    <path class="second fill-red-600 origin-center transition-transform duration-300"
                                        :class="liked ? 'scale-100' : 'scale-0'"
                                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                </svg>
                            </div>
                        @else
                            <div x-cloak @click="$dispatch('open-login-modal')"
                                class="relative cursor-pointer flex items-center justify-center">

                                <!-- Heart SVG Icon -->
                                <svg class="w-14 h-14 relative z-20 transition-all duration-200 mb-[2px]"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        class="main fill-transparent stroke-darkGrey stroke-2 origin-center transition-transform duration-300"
                                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                </svg>
                            </div>
                        @endauth
                    </div>
                    {{-- Si l'artiste est sur son propre kiosque l'empecher d'acheter --}}
                    @if ($article->artiste->id_user != Auth::id())
                        <form action="{{ '/addArticleToPanier' }}" method="POST">
                            @csrf
                            <button type="submit" value="{{ $article->id_article }}" name="id_article"
                                class="border-darkGrey border rounded-[24px] w-[100%] h-[40px] articleGrand-dark">Ajouter
                                au
                                panier</button>
                        </form>
                    @else
                        <button type="button" value="{{ $article->id_article }}" name="id_article"
                            class="border-darkGrey border rounded-[24px] w-[100%] h-[40px] articleGrand-dark">En vedette</button>
                    @endif
                </div>
            @endif
        @endforeach
    </div>


    {{-- Flèche droite --}}

    <svg id="nextBtn"
        class="text-darkGrey absolute right-0 cursor-pointer z-[10] transition-transform duration-200 transform hover:scale-[115%]"
        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none"
        viewBox="4 4 16 16">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
    </svg>

</div>
