{{-- Conteneur --}}
<div class="flex flex-col gap-input items-center p-Y p-X absolute z-[21] bg-beigeFoncé rounded-[16px] shadow -left-20 top-[38px] opacity-0 invisible transition-all duration-200" id="kiosqueFiltres">

    <!-- Barre de recherche -->
    <div class="w-[200px] h-[39px] py-auto flex border rounded border-black">
        <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
            placeholder="Rechercher par nom..." name="search" id="searchArticle">
    </div>

    {{-- Filtre prix --}}
    <div class="filter-item">
        <label for="typePieceFiltre" class="block textPetit-dark font-medium">Prix ($)</label>
        <div class="flex gap-2 items-center w-[200px] h-[39px] justify-between ">
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
            class="h-[39px] w-[200px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
            class="h-[39px] w-[200px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="1">Unique</option>
            <option value="0">En série</option>
            <option value="null" selected>Tous</option>
        </select>
    </div>

    {{-- Filtre de date --}}
    <div class="filter-item">
        <label for="dateFiltre" class="block textPetit-dark font-medium">Date de création</label>
        <select id="dateFiltre" name="dateFiltre" data-url="{{ route('kiosqueFiltre') }}"
            class="h-[39px] w-[200px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="1" selected>Plus récent</option>
            <option value="0">Moins récent</option>
        </select>
    </div>

    <input type="hidden" name="idArtiste" id="idArtiste" value="{{$artiste->id_user}}">

    {{-- Clear filtre --}}
    <div class="flex w-[200px] items-center justify-center">
        <x-button.red.empty type="submit" id="clearFiltre" value="0">
            Effacer les filtres
        </x-button.red.empty>
    </div>
</div>
