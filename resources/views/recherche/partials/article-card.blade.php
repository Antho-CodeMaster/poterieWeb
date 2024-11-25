@if ($article->id_etat != 2 && $article->quantite_disponible > 0)
    <div x-data='{openArticleModal: false}'
    class="inline mx-2 shrink-0 overflow-hidden whitespace-nowrap rounded-[16px] bg-white shadow-md hover:shadow-lg">
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

        {{-- Image section --}}
        <div class="flex justify-center mb-2">
            <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                class="{{($article->is_sensible == 1 && !Auth::check()) || (Auth::check() && Auth()->user()->contenu_sensible == 0 && $article->is_sensible == 1) ? 'blur-[18px]' : ''}} shadow-md rounded-[12px] cursor-pointer h-[250px] w-[250px] object-cover"
                @click=" $dispatch('open-article-modal');
                            $dispatch('set-article', {
                                id_article: '{{ $article->id_article }}',
                                id_artiste: '{{ $article->artiste->id_artiste }}',
                                id_etat: '{{ $article->id_etat }}',
                                nom: '{{ htmlspecialchars($article->nom) }}',
                                description: '{{ htmlspecialchars($article->description) }}',
                                prix: '{{ number_format($article->prix, 2, ',', ' ') }}',
                                hauteur: '{{ number_format($article->hauteur, 2, ',', ' ') }}',
                                largeur: '{{ number_format($article->largeur, 2, ',', ' ') }}',
                                profondeur: '{{ number_format($article->profondeur, 2, ',', ' ') }}',
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
        </div>

        {{-- Article info section --}}
        <div class="flex flex-col items-start mb-2">
            <p class="smallArticle font-bold text-lg">{{ $article->nom }}</p>
            <p class="text-[11px] font-bold text-darkGrey">{{ $article->prix }}$</p>
        </div>

        {{-- Like section --}}
        <div class="flex">
            <span class="flex justify-start w-[75%]"></span>

            @if ($article->isLikedByUser(Auth::id()))
                <svg class="w-12 h-12 text-darkGery justify-end m-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ff0000" viewBox="0 0 24 24">
                    <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                </svg>
            @else
                <svg class="w-12 h-12 text-gray-800 dark:text-white justify-end m-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                </svg>
            @endif
        </div>

        {{-- Button section --}}
        <div class="flex items-end">
            <div class="flex justify-center items-end w-[75%]">
                @if ($article->quantite_disponible == 0)
                    <p
                        class="border-darkGrey border rounded-[24px] w-full h-[32px] text-beige font-bold bg-darkGrey text-center">
                        En rupture de stock
                    </p>
                @else
                    @auth
                        {{$ajoute = $panier->contains('id_article',$article->id_article)}}
                    @else
                        {{$ajoute = in_array($article->id_article,$panier)}}
                    @endauth
                    <button class="w-full add-to-cart overflow-hidden whitespace-nowrap border-darkGrey border rounded-[24px] h-[32px] text-darkGrey font-bold" x-data="{ajoute: {{$ajoute ? 'true' : 'false'}}}" @click="addToCart({{ $article->id_article }}); ajoute = !ajoute"
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
@endif
