<div class="w-[160px] mx-[16px] my-[16px] whitespace-nowrap">

    {{-- Changer l'image selon l'état de l'article --}}
    @if ($article->id_etat == 2)
        <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
            class="shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover">
    @elseif ($article->quantite_disponible = 0 && $article->id_etat == 1)
        <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
            class="shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover">
    @else
        <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
            class="shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover">
    @endif

    <div class="flex justify-between items-center my-[4px]">
        <div class="w-[75%]">
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
        @if ($article->quantite_disponible == 0)
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
