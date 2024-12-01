<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height" x-data="{ openDelete: false, openRetrieve: false }"">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 w-full h-[100%] flex flex-col">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <div class="flex border-b-2 border-darkGrey gap-5 justify-between">
                    <h1 class="titre2-dark m-titreY p-sectionY">Articles en vente</h1>
                    <!-- Navigateur de pages-->
                    <div class="flex items-center gap-2">
                        <?php
                        switch ($page) {
                            case 0:
                            case 1:
                                $initial = 1;
                                $final = 4;
                                break;
                            case $total_pages - 2:
                                $initial = $page - 2;
                                $final = $page + 1;
                                break;
                            case $total_pages - 1:
                                $initial = $page - 3;
                                $final = $page + 1;
                                break;
                            default:
                                $initial = $page - 1;
                                $final = $page + 2;
                                break;
                        }
                        ?>
                        <p>Page: </p>
                        @for ($i = $initial; $i <= $final && $i < $total_pages; $i++)
                            <a class="px-4 py-2 rounded
                        {{ $page + 1 == $i ? 'bg-darkGrey text-white' : '' }}"
                                href="{{ route('admin-articles') . '?page=' . $i }}">
                                {{ $i }}</a>
                        @endfor
                        @if ($page + 3 < $total_pages)
                            <p>...</p>
                        @endif
                        <a class="px-4 py-2 rounded
                    {{ $page + 1 == $total_pages ? 'bg-darkGrey text-white' : '' }}"
                            href="{{ route('admin-articles') . '?page=' . $total_pages }}">
                            {{ $total_pages }}</a>
                    </div>
                </div>
                <h2 class="text-2xl text-darkGrey">{{ $page * 50 + 1 }} à
                    {{ $page * 50 + 50 > $count ? $count : $page * 50 + 50 }} de {{ $count }} résultats</h2>
                <form method="get" action="{{ route('admin-articles') }}" class="flex items-center justify-end"
                    id="filterForm">
                    <input id="pageID" type="hidden" name="page" value="1">
                    <!-- Sélection du type d'utilisateur -->
                    <label class="textMoyen-dark mr-2" for="sensible">Sensible</label>
                    <input class="mr-6 scale-150" type="checkbox" id="sensible" name="sensible" value="true" {{ $sensible == 'true' ? 'checked' : '' }}>
                    <label class="textMoyen-dark mr-2" for="vedette">En vedette</label>
                    <input class="mr-6 scale-150" type="checkbox" id="vedette" name="vedette" value="true" {{ $vedette == 'true' ? 'checked' : '' }}>
                    <label class="textMoyen-dark mr-6" for="etat">Visibilité : </label>
                    <select id="etat" name="etat" class="mr-6 border rounded border-black">
                        <option {{ $etat == 'tous' || $etat == null || $etat == '' ? 'selected' : '' }} value="tous">
                            Public & masqué</option>
                        <option {{ $etat == 'Public' ? 'selected' : '' }} value="Public">Public</option>
                        <option {{ $etat == 'Masqué' ? 'selected' : '' }} value="Masqué">Masqué aux clients</option>
                        <option {{ $etat == 'Supprimé' ? 'selected' : '' }} value="Supprimé">Supprimé du site</option>
                    </select>

                    <!-- Barre de recherche -->
                    <div id="search-user" class="w-[500px] h-[50px] py-auto flex border rounded border-black">
                        <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                            placeholder="Rechercher par nom / par artiste..." name="query"
                            value="{{ $query }}">
                        <button>
                            <svg class="w-6 h-6 mr-3 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex grow overflow-y-auto flex-wrap mt-5">
                @foreach ($articles as $article)
                    @include('admin.components.article-card')
                @endforeach
                @if ($articles->isEmpty())
                    <p class="text-center">Aucun article à afficher sur cette page.</p>
                @endif
            </div>
            @include('admin.components.delete-article-modal')
            @include('admin.components.retrieve-article-modal')
            @include('admin.components.article-modal')


            @if (Session::has('succes'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageSucces', [
                        'message' => Session::get('succes'),
                        'titre' => 'Succès',
                    ])
                </div>
            @endif
            @if (Session::has('erreur'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageFail', [
                        'message' => Session::get('erreur'),
                        'titre' => 'Erreur',
                    ])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
