<div class="my-20" data-collection-id="{{ $collectionName }}">
    <h2 class="titre font-semibold mx-4 mt-8 mb-2">{{ $collectionName }}</h2>

        <div class="relative flex items-center">
            <!-- Left Arrow -->
            <button id="prevBtn-{{ $collectionName }}" class="prev-btn">
                <svg class="h-12 w-12 text-darkGrey absolute cursor-pointer z-10" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
            </button>

            <!-- Carousel Wrapper -->
            <div id="carousel-{{ $collectionName }}"
                class="carousel bg-beige p-2 flex overflow-x-scroll scroll-smooth whitespace-nowrap scrollbar-hide w-full">
                @foreach ($collection as $article)
                    <div x-data='{openArticleModal: false}'
                        class="inline lg:w-[17%] sm:w-[90%] lg:mx-6 mx-2 shrink-0 overflow-hidden whitespace-nowrap rounded-[16px] bg-white shadow-md hover:shadow-lg">
                        <img src="/../img/{{ $article->photosArticle->path }}" alt="{{ $article->nom }}"
                            class="{{($article->is_sensible == 1 && !Auth::check()) || (Auth::check() && Auth()->user()->contenu_sensible == 0 && $article->is_sensible == 1) ? 'blur-[18px]' : ''}} w-full h-64 object-cover rounded-t-md"
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
                                couleur: '{{ $article->couleur }}',
                                quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                is_unique: '{{ $article->is_unique }}',
                                is_alimentaire: '{{ $article->is_alimentaire }}',
                                is_sensible: '{{ $article->is_sensible }}',
                            });
                            $dispatch('set-artiste', '{{ $article->artiste }}');
                            $dispatch('set-photos', '{{ $article->photo_article }}');
                            $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                        <div class="h-fit flex flex-row p-4">
                            <div class="flex-col w-[70%] h-full">
                                <h3 class="text-lg font-bold text-nowrap overflow-hidden text-ellipsis">{{ $article->nom }}</h3>
                                <p class="text-gray-600">{{ $article->prix }}$</p>

                                <div class="mt-8 overflow-hidden whitespace-nowrap">
                                    @if ($article->quantite_disponible == 0)
                                        <p
                                            class="border-darkGrey border rounded-[24px] w-full h-[32px] text-beige font-bold bg-darkGrey text-center">
                                            En rupture de stock
                                        </p>
                                    @else
                                        <button class="w-full add-to-cart overflow-hidden whitespace-nowrap border-darkGrey border rounded-[24px] h-[32px] text-darkGrey font-bold" x-data="{ajoute: {{$panier->contains('id_article',$article->id_article) ? 'true' : 'false'}}}" @click="addToCart({{ $article->id_article }}); ajoute = !ajoute"
                                            :class="ajoute ? 'added':''">
                                            <div value="{{ $article->id_article }}" name="id_article"
                                                class="default m-auto">
                                                Ajouter au panier
                                            </div>
                                            <div class="success">Ajouté</div>
                                            <div class="cart">
                                                <div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col justify-end w-[20%] h-fit ml-auto">
                                <div class="flex flex-col items-center">
                                    @auth
                                        <div x-cloak
                                            x-data="{ liked: {{ json_encode($article->isLikedByUser(Auth::id()) != "" ? true : false) }} }"
                                            @click="toggleLike({{ $article->id_article }}); liked = !liked"
                                            class="relative cursor-pointer w-auto h-auto">

                                            <!-- Heart SVG Icon -->
                                            <svg width="32" height="32" viewBox="12 18 24 24" class="relative z-20 transition-all duration-200">
                                                <path :class="liked ? 'scale-0' : 'scale-100'"
                                                    class="main fill-transparent stroke-darkGrey stroke-2 origin-bottom-right transition-transform duration-300"
                                                    d="M24 23c1.2-1.2 2.8-1.8 4.5-1.8 3.8 0 6.5 3.4 6.5 7 0 4.5-6.8 10-10 12.3-0.7 0.4-1 0.4-1.6 0C20.2 38.2 13.5 32.7 13.5 28c0-3.6 2.8-7 6.5-7 1.7 0 3.3 0.6 4.5 1.8z" />
                                                <path :class="liked ? 'scale-100' : 'scale-0'"
                                                    class="second fill-red-600 origin-bottom-right transition-transform duration-300"
                                                    d="M24 23c1.2-1.2 2.8-1.8 4.5-1.8 3.8 0 6.5 3.4 6.5 7 0 4.5-6.8 10-10 12.3-0.7 0.4-1 0.4-1.6 0C20.2 38.2 13.5 32.7 13.5 28c0-3.6 2.8-7 6.5-7 1.7 0 3.3 0.6 4.5 1.8z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div x-cloak @click="$dispatch('open-login-modal')"
                                        class="relative cursor-pointer w-auto h-auto">

                                            <!-- Heart SVG Icon -->
                                            <svg width="32" height="32" viewBox="12 18 24 24" class="relative z-20">
                                                <path class="fill-transparent stroke-darkGrey stroke-2"
                                                    d="M24 23c1.2-1.2 2.8-1.8 4.5-1.8 3.8 0 6.5 3.4 6.5 7 0 4.5-6.8 10-10 12.3-0.7 0.4-1 0.4-1.6 0C20.2 38.2 13.5 32.7 13.5 28c0-3.6 2.8-7 6.5-7 1.7 0 3.3 0.6 4.5 1.8z" />
                                                </svg>
                                        </div>
                                    @endauth

                                    <span class="my-5"></span>

                                    <img src="{{ asset($article->getArtiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                        alt="{{ $article->getArtiste->nom_artiste }}"
                                        class="rounded-full w-[48px] h-[48px]">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Arrow -->
            <button id="nextBtn-{{ $collectionName }}" class="next-btn">
                <svg class="h-12 w-12 text-darkGrey absolute right-0 cursor-pointer z-10" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
</div>
