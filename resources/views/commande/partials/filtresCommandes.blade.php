<div class="flex justify-between w-full mt-1.5">

    <!-- Barre de recherche -->
    <div class="filter-item">
        <label for="search" class="block textPetit-dark font-medium">Recherche par nom de client ou d'article</label>
        <div class="w-[300px] h-[39px] py-auto flex border rounded border-black ">
            <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                placeholder="Rechercher" name="search" id="searchArticle">
        </div>
    </div>

    <div class="flex justify-end gap-inputXXL items-end">
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

        {{-- Clear filtre --}}
        <x-button.red.empty type="submit" id="clearFiltre" value="0" class="w-[200px]">
            Effacer les filtres
        </x-button.red.empty>
    </div>
</div>
