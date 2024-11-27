@if ($articles->isEmpty()) <!-- Vérifie si la collection est vide -->
    <p class="textGrand-dark m-section">Aucun article correspondant à ces filtres</p>
@else
    @foreach ($articles as $article)
        @if ($article->etat->etat == 'Visible client' || $article->etat->etat == 'Masqué client')
            <div class="w-[170px] m-article whitespace-nowrap">
                {{-- L'image de l'Article --}}
                <div
                    class="w-[160px] h-[160px] relative hover:scale-[103%] hover:shadow-md rounded-[16px] transition-all ease-in-out duration-200">
                    <div x-data="{ openArticleModal: false }" class="overflow-hidden rounded-[16px]">
                        @if (Auth::check())
                            @if (Auth::user()->contenu_sensible == 1)
                                @if ($article->id_etat == 2)
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                            $dispatch('set-article', {
                                                id_article: '{{ $article->id_article }}',
                                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                                id_etat: '{{ $article->id_etat }}',
                                                nom: '{{ htmlspecialchars($article->nom) }}',
                                                description: '{{ htmlspecialchars($article->description) }}',
                                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                                hauteur: '{{ $article->hauteur }}',
                                                largeur: '{{ $article->largeur }}',
                                                profondeur: '{{ $article->profondeur }}',
                                                poids: '{{ $article->poids }}',
                                                quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                is_unique: '{{ $article->is_unique }}',
                                                is_alimentaire: '{{ $article->is_alimentaire }}',
                                                is_sensible: '{{ $article->is_sensible }}',
                                            });
                                            $dispatch('set-artiste', '{{ $article->artiste }}');
                                            $dispatch('set-photos', '{{ $article->photo_article }}');
                                            $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                            $dispatch('set-article', {
                                                id_article: '{{ $article->id_article }}',
                                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                                id_etat: '{{ $article->id_etat }}',
                                                nom: '{{ htmlspecialchars($article->nom) }}',
                                                description: '{{ htmlspecialchars($article->description) }}',
                                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                                hauteur: '{{ $article->hauteur }}',
                                                largeur: '{{ $article->largeur }}',
                                                profondeur: '{{ $article->profondeur }}',
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
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                            $dispatch('set-article', {
                                                id_article: '{{ $article->id_article }}',
                                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                                id_etat: '{{ $article->id_etat }}',
                                                nom: '{{ htmlspecialchars($article->nom) }}',
                                                description: '{{ htmlspecialchars($article->description) }}',
                                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                                hauteur: '{{ $article->hauteur }}',
                                                largeur: '{{ $article->largeur }}',
                                                profondeur: '{{ $article->profondeur }}',
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
                                @if ($article->id_etat == 2)
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover transition-all ease-in-out duration-200 {{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }}"
                                        @click=" $dispatch('open-article-modal');
                                            $dispatch('set-article', {
                                                id_article: '{{ $article->id_article }}',
                                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                                id_etat: '{{ $article->id_etat }}',
                                                nom: '{{ htmlspecialchars($article->nom) }}',
                                                description: '{{ htmlspecialchars($article->description) }}',
                                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                                hauteur: '{{ $article->hauteur }}',
                                                largeur: '{{ $article->largeur }}',
                                                profondeur: '{{ $article->profondeur }}',
                                                poids: '{{ $article->poids }}',
                                                quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                is_unique: '{{ $article->is_unique }}',
                                                is_alimentaire: '{{ $article->is_alimentaire }}',
                                                is_sensible: '{{ $article->is_sensible }}',
                                            });
                                            $dispatch('set-artiste', '{{ $article->artiste }}');
                                            $dispatch('set-photos', '{{ $article->photo_article }}');
                                            $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                            $dispatch('set-article', {
                                                id_article: '{{ $article->id_article }}',
                                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                                id_etat: '{{ $article->id_etat }}',
                                                nom: '{{ htmlspecialchars($article->nom) }}',
                                                description: '{{ htmlspecialchars($article->description) }}',
                                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                                hauteur: '{{ $article->hauteur }}',
                                                largeur: '{{ $article->largeur }}',
                                                profondeur: '{{ $article->profondeur }}',
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
                                        class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                            $dispatch('set-article', {
                                                id_article: '{{ $article->id_article }}',
                                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                                id_etat: '{{ $article->id_etat }}',
                                                nom: '{{ htmlspecialchars($article->nom) }}',
                                                description: '{{ htmlspecialchars($article->description) }}',
                                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                                hauteur: '{{ $article->hauteur }}',
                                                largeur: '{{ $article->largeur }}',
                                                profondeur: '{{ $article->profondeur }}',
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
                            @endif
                        @else
                            @if ($article->id_etat == 2)
                                <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                    class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover transition-all ease-in-out duration-200 {{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }}"
                                    @click=" $dispatch('open-article-modal');
                                        $dispatch('set-article', {
                                            id_article: '{{ $article->id_article }}',
                                            id_artiste: '{{ $article->artiste->id_artiste }}',
                                            id_etat: '{{ $article->id_etat }}',
                                            nom: '{{ htmlspecialchars($article->nom) }}',
                                            description: '{{ htmlspecialchars($article->description) }}',
                                            prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                            hauteur: '{{ $article->hauteur }}',
                                            largeur: '{{ $article->largeur }}',
                                            profondeur: '{{ $article->profondeur }}',
                                            poids: '{{ $article->poids }}',
                                            quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                            is_unique: '{{ $article->is_unique }}',
                                            is_alimentaire: '{{ $article->is_alimentaire }}',
                                            is_sensible: '{{ $article->is_sensible }}',
                                        });
                                        $dispatch('set-artiste', '{{ $article->artiste }}');
                                        $dispatch('set-photos', '{{ $article->photo_article }}');
                                        $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                            @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                    class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                    @click=" $dispatch('open-article-modal');
                                        $dispatch('set-article', {
                                            id_article: '{{ $article->id_article }}',
                                            id_artiste: '{{ $article->artiste->id_artiste }}',
                                            id_etat: '{{ $article->id_etat }}',
                                            nom: '{{ htmlspecialchars($article->nom) }}',
                                            description: '{{ htmlspecialchars($article->description) }}',
                                            prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                            hauteur: '{{ $article->hauteur }}',
                                            largeur: '{{ $article->largeur }}',
                                            profondeur: '{{ $article->profondeur }}',
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
                                    class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover transition-all ease-in-out duration-200"
                                    @click=" $dispatch('open-article-modal');
                                        $dispatch('set-article', {
                                            id_article: '{{ $article->id_article }}',
                                            id_artiste: '{{ $article->artiste->id_artiste }}',
                                            id_etat: '{{ $article->id_etat }}',
                                            nom: '{{ htmlspecialchars($article->nom) }}',
                                            description: '{{ htmlspecialchars($article->description) }}',
                                            prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                            hauteur: '{{ $article->hauteur }}',
                                            largeur: '{{ $article->largeur }}',
                                            profondeur: '{{ $article->profondeur }}',
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
                        @endif
                    </div>

                    {{-- Changer l'image selon l'état de l'article --}}
                    @if (Auth::id() == $artiste->id_user)
                        <!-- Trigger Button for DeleteArticle Modal -->
                        <div class="w-fit" x-data="{ openDeleteArticle: false }">
                            <button
                                @click=" $dispatch('open-delete-article-modal');
                                         $dispatch('set-id', {{ $article->id_article }});">
                                <svg class="w-9 h-9 text-blue-900 hover:text-red-600  absolute top-0 right-0"
                                    width="40" height="44" viewBox="0 0 40 44" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 10H6M6 10H38M6 10V38C6 39.0609 6.42143 40.0783 7.17157 40.8284C7.92172 41.5786 8.93913 42 10 42H30C31.0609 42 32.0783 41.5786 32.8284 40.8284C33.5786 40.0783 34 39.0609 34 38V10M12 10V6C12 4.93913 12.4214 3.92172 13.1716 3.17157C13.9217 2.42143 14.9391 2 16 2H24C25.0609 2 26.0783 2.42143 26.8284 3.17157C27.5786 3.92172 28 4.93913 28 6V10M16 20V32M24 20V32"
                                        stroke="#FC6262" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                        class="" />
                                </svg>
                            </button>
                        </div>
                        @include('kiosque.deleteArticle-modal')

                        {{-- Bouton pour modifier l'article --}}
                        <form action="{{ route('modifArticleForm', ['idArticle' => $article->id_article]) }}"
                            class="absolute top-0 left-0 z-[10]" method="get">
                            @csrf
                            <button type="submit">
                                <svg class="w-12 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                    viewBox="0 0 24 24" stroke="#444444">
                                    <path fill-rule="evenodd"
                                        d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>

                <div class="flex justify-between items-center my-[4px]">
                    <div class="w-[75%]">
                        <p class=" articlePetit-dark">{{ $article->nom }}</p>
                        <p class="textPetit-dark">{{ number_format($article->prix, 2, ',', ' ') }}$
                        </p>
                    </div>

                    {{-- Vérifie chaque like du user avec l'article --}}
                    @auth
                        <div x-cloak x-data="{ liked: {{ json_encode($article->isLikedByUser(Auth::id()) != '' ? true : false) }} }"
                            @click="toggleLike({{ $article->id_article }}); liked = !liked"
                            class="relative cursor-pointer flex items-center justify-center ">
                            <svg class="w-10 h-10 mb-[2px] relative z-20 transition-all duration-200"
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
                            <svg class="w-10 h-10 relative z-20 transition-all duration-200 mb-[2px]"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    class="main fill-transparent stroke-darkGrey stroke-2 origin-center transition-transform duration-300"
                                    d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                            </svg>
                        </div>
                    @endauth
                </div>

                {{-- Changer le bouton selon l'état de l'article --}}
                @if ($article->id_etat == 2)
                    <p
                        class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-light bg-darkGrey text-center">
                        Masqué</p>
                @elseif ($article->id_etat == 1)
                    @if ($article->quantite_disponible == 0)
                        <p
                            class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-light bg-darkGrey text-center">
                            En rupture de stock</p>
                    @elseif ($article->quantite_disponible > 0)
                        {{-- Si l'artiste est sur son propre kiosque l'empecher d'acheter --}}
                        @if ($article->artiste->id_user != Auth::id())
                            <form action="{{ '/addArticleToPanier' }}" method="POST">
                                @csrf
                                <button type="submit" value="{{ $article->id_article }}" name="id_article"
                                    class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-dark">Ajouter
                                    au
                                    panier</button>
                            </form>
                        @else
                            <button type="button" value="{{ $article->id_article }}" name="id_article"
                                class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-dark cursor-default">Visible</button>
                        @endif
                    @endif
                @endif
            </div>
        @endif
    @endforeach
@endif
