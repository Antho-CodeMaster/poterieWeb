<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pt-20 px-20 h-[100%] flex flex-col">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="text-4xl text-black">Articles en vente</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof([]) }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
        </div>
    </div>
</x-app-layout>
