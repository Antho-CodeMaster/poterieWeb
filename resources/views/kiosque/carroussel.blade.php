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
                <div class="w-[300px] m-article flex-shrink-0  whitespace-nowrap" x-data="{ openArticleModal: false }">
                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                        class="shadow-md rounded-[16px] cursor-pointer w-full h-[300px] object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                        @click=" $dispatch('open-article-modal');
                                 console.log('Dispatching set-article');
                                 $dispatch('set-article', '{{ $article }}');
                                 $dispatch('set-photos', '{{ $article->photo_article }}');
                                 $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">

                    <div class="flex justify-between items-center my-[10px]">
                        <div class="w-[80%]">
                            <p class=" articleGrand-dark ">{{ $article->nom }}</p>
                            <p id="prix" class="articlePetit-dark">{{ $article->prix }}$
                            </p>
                        </div>

                        {{-- Vérifie chaque like du user avec l'article --}}
                        @if ($article->isLikedByUser(Auth::id()))
                            <svg class="w-10 h-10 text-darkGery" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="#ff0000" viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                            </svg>
                        @else
                            <svg class="w-10 h-10 text-gray-800 dark:text-white mb-[2px]" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                            </svg>
                        @endif
                    </div>
                    <form action="{{ '/addArticleToPanier' }}" method="POST">
                        @csrf
                        <button type="submit" value="{{ $article->id_article }}" name="id_article"
                            class="border-darkGrey border rounded-[24px] w-[100%] h-[40px] articleGrand-dark">Ajouter
                            au
                            panier
                        </button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>


    {{-- Flèche droite --}}

    <svg id="nextBtn" class="text-darkGrey absolute right-0 cursor-pointer z-[10] transition-transform duration-200 transform hover:scale-[115%]" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
    </svg>

</div>
