<section class="m-collection" x-data='{openDeleteArticle: false}' x-data='{openArticleModal: false}'>
    <div class="flex justify-between items-end">
        <div class="flex items-center">
            <h2 class=" titre2-dark mx-[16px] mr-[2px] m-titreY select-none">Tous les articles</h2>

            <div class="relative">
                {{-- Bouton de filtre --}}
                <svg class="w-8 h-8 cursor-pointer select-none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" id="btnFiltres"
                    width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                    <path
                        d="M10.83 5a3.001 3.001 0 0 0-5.66 0H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17ZM4 11h9.17a3.001 3.001 0 0 1 5.66 0H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2Zm1.17 6H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17a3.001 3.001 0 0 0-5.66 0Z" />
                </svg>
                @include('kiosque.partials.tousLesArticles.filtreKiosque')
            </div>
        </div>


    </div>

    {{--  --}}
    <div class="bg-beige flex flex-wrap justify-between min-h-[350px]" id="articlesContainer">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Affichage de tous les articles --}}
        @if ($hasArticle == false)
            @if (Auth::id() == $artiste->id_user)
                <div class="bg-beige p-sectionY">
                    <p class=" textGrand-dark mx-[16px] select-none font-bold">Pour le moment vous n'avez aucun
                        article en vente.
                    </p>
                    <a href="{{ route('addArticleForm', ['idArticle' => 1]) }}"
                        class=" textMoyen-dark underline mx-[16px]">Ajouter un article </a>
                </div>
            @else
                <p>Aucun article pour le moment</p>
            @endif
        @else
            @include('kiosque.partials.tousLesArticles.allArticlesKiosque')
        @endif
    </div>

    {{-- Les modals --}}
    @include('kiosque.article-modal')
</section>
