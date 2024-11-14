<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col">
            <h1 class=" m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Tous mes articles</h1>

            <div class="flex gap-inputXXL contenuFiltre">
                {{-- Filtres de recherche --}}
                <meta name="csrf-token" content="{{ csrf_token() }}">

                @include('articleSettings.partials.filtresArticles')
                @include('articleSettings.partials.allArticles')
            </div>
        </div>
    </div>
</x-app-layout>
