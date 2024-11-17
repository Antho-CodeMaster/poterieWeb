<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height" x-data="{ openDelete: false }"">
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
                    {{ ($page * 50 + 50) > $count ? $count : ($page * 50 + 50)}} de {{ $count }} résultats</h2>
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
