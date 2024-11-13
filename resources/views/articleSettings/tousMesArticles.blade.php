<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col">
            <h1 class=" m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Tous mes articles</h1>

            <div class="flex gap-inputXXL contenuFiltre">
                {{-- Filtres de recherche --}}
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="flex flex-col gap-4 items-center p-sectionY">
                    <!-- Barre de recherche -->
                    <div class="w-[180px] h-[39px] py-auto flex border rounded border-black">
                        <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                            placeholder="Rechercher par nom..." name="search" id="searchArticle">
                        <button>
                            <svg class="w-6 h-6 mr-3 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Filtre prix --}}
                    <div class="filter-item">
                        <label for="typePieceFiltre" class="block textPetit-dark font-medium">Prix ($)</label>
                        <div class="flex gap-2 items-center w-[180px] h-[39px] justify-between ">
                            <input type="number" name="prixFiltreMin" id="prixFiltreMin"
                                class="w-[45%] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Min" min="0" max="9999">
                            <p class=" textGrand-dark w-[10%] text-center"> à </p>
                            <input type="number" name="prixFiltreMax" id="prixFiltreMax"
                                class="w-[45%] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Max" min="0" max="9999">
                        </div>
                    </div>

                    {{-- Filtre type d'usage --}}
                    <div class="filter-item">
                        <label for="typePieceFiltre" class="block textPetit-dark font-medium">Type
                            d'usage</label>
                        <select id="typePieceFiltre" name="typePieceFiltre" required
                            class="h-[39px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1">Alimentaire</option>
                            <option value="0">Non-alimentaire</option>
                            <option value="null" selected>Tous</option>
                        </select>
                    </div>

                    {{-- Filtre type de pièce --}}
                    <div class="filter-item">
                        <label for="pieceUniqueFiltre" class="block textPetit-dark font-medium">Type de
                            pièce</label>
                        <select id="pieceUniqueFiltre" name="pieceUniqueFiltre"
                            class="h-[39px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1">Unique</option>
                            <option value="0">En série</option>
                            <option value="null" selected>Tous</option>
                        </select>
                    </div>

                    {{-- Filtre "Masqué" --}}
                    <div class="filter-item">
                        <label for="masqueFiltre" class="block textPetit-dark font-medium">Visibilité</label>
                        <select id="masqueFiltre"
                            class="h-[39px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1">Visible</option>
                            <option value="2">Masqué</option>
                            <option value="null" selected>Tous</option>
                        </select>
                    </div>

                    {{-- Filtre "En vedette" --}}
                    <div class="filter-item">
                        <label for="vedetteFiltre" class="block textPetit-dark font-medium">En vedette</label>
                        <select id="vedetteFiltre"
                            class="h-[39px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1">Vedette</option>
                            <option value="0">Commun</option>
                            <option value="null" selected>Tous</option>
                        </select>
                    </div>

                    {{-- Filtre "Sensible" --}}
                    <div class="filter-item">
                        <label for="sensibleFiltre" class="block textPetit-dark font-medium">Sensibilité</label>
                        <select id="sensibleFiltre"
                            class="h-[39px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1">Sensible</option>
                            <option value="0">Insensible</option>
                            <option value="null" selected>Tous</option>
                        </select>
                    </div>

                    {{-- Filtre type de pièce --}}
                    <div class="filter-item">
                        <label for="dateFiltre" class="block textPetit-dark font-medium">Date de création</label>
                        <select id="dateFiltre" name="dateFiltre" data-url="{{ route('articleFiltre') }}"
                            class="h-[39px] w-[180px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1" selected>Plus récent</option>
                            <option value="0">Moins récent</option>
                        </select>
                    </div>

                    {{-- Clear filtre --}}
                    <form class="flex w-[180px] items-center justify-center"
                        action="{{ route('tousMesArticles') }}" method="GET">
                        <x-button.red.empty type="submit" id="clearFiltre" value="0">
                            Effacer les filtres
                        </x-button.red.empty>
                    </form>
                </div>

                @include('articleSettings.partials.allArticles')
            </div>
        </div>
    </div>
</x-app-layout>
