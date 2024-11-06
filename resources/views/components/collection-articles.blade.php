<div class="collection my-20" data-collection-id="{{ $collection->id_collection }}">
    <h2 class="titre font-semibold mt-8 mb-4">{{ $collection->collection }}</h2>

    @if ($collection->articles->isEmpty())
        <p>Aucun article disponible dans cette collection.</p>
    @else
        <div class="relative flex items-center">
            <!-- Left Arrow -->
            <button id="prevBtn-{{ $collection->id_collection }}" class="prev-btn">
                <svg class="h-12 w-12 text-darkGrey absolute cursor-pointer z-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7"/>
                </svg>
            </button>

            <!-- Carousel Wrapper -->
            <div id="carousel-{{ $collection->id_collection }}" class="carousel bg-beige p-2 flex overflow-x-scroll scroll-smooth whitespace-nowrap scrollbar-hide w-full">
                @foreach($collection->articles as $article)
                    <div x-data='{openArticleModal: false}' class="inline-block w-[300px] mx-2 flex-shrink-0 overflow-hidden whitespace-nowrap bg-white shadow-md rounded-md">
                        <img @click=" $dispatch('open-article-modal');
                        console.log('Dispatching set-article');
                        $dispatch('set-article', '{{ $article }}');
                        $dispatch('set-photos', '{{ $article->photo_article }}');
                        $dispatch('set-mots-cles', '{{ $article->motCles }}');"
                        src="/../img/{{ $article->photosArticle->path }}" alt="{{ $article->nom }}" class="w-full h-48 object-cover rounded-t-md">
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-nowrap overflow-hidden text-ellipsis">{{ $article->nom }}</h3>
                            <p class="text-gray-600">{{ $article->prix }}$</p>
                            <div class="flex items-end justify-between m-2">
                                <div class="flex justify-center items-end w-[75%]">
                                    @if ($article->quantite_disponible == 0)
                                        <p class="border-darkGrey border rounded-[24px] w-full h-[32px] text-beige font-bold bg-darkGrey text-center">
                                            En rupture de stock
                                        </p>
                                    @else
                                        <form action="{{ route('addArticleToPanier') }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" value="{{$article->id_article}}" name="id_article" class="border-darkGrey border rounded-[24px] w-full h-[32px] text-darkGrey font-bold">
                                                Ajouter au panier
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="flex flex-col items-center justify-end mx-2">
                                    @if ($article->isLikedByUser(Auth::id()))
                                        <svg class="w-6 h-6 mb-1 text-red-500" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z"/>
                                        </svg>
                                    @else
                                        <svg class="w-12 h-12 mb-1 text-gray-800 dark:text-white" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/>
                                        </svg>
                                    @endif
                                    <img src="{{ asset($article->getArtiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}" alt="{{ $article->getArtiste->nom_artiste }}" class="rounded-full w-[48px] h-[48px]">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Arrow -->
            <button id="nextBtn-{{ $collection->id_collection }}" class="next-btn">
                <svg class="h-12 w-12 text-darkGrey absolute right-0 cursor-pointer z-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        {{-- Les modals --}}
        @include('kiosque.article-modal')
    @endif
</div>
