<div class="flex justify-between w-full mt-1.5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Barre de recherche -->
    <div class="filter-item">
        <label for="search" class="block textPetit-dark font-medium">Rechercher par nom de client ou d'article</label>
        <div class="w-[300px] h-[39px] py-auto flex border rounded border-black ">
            <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                placeholder="Rechercher" name="search" id="searchTransaction">
        </div>
    </div>

    <div class="flex justify-end gap-inputXXL items-end">
        {{-- Filtre de compagnie de livraison --}}
        <div class="filter-item">
            <label for="compagnieFiltre" class="block textPetit-dark font-medium">Compagnie de livraison</label>
            <select id="compagnieFiltre" name="compagnieFiltre" required
                class="h-[39px] w-[200px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="3">FedEx</option>
                <option value="2">Postes Canada</option>
                <option value="1">Purolator</option>
                <option value="null" selected>Tous</option>
            </select>
        </div>

        {{-- Filtre de statut --}}
        <div class="filter-item">
            <label for="statutFiltre" class="block textPetit-dark font-medium">Statut de transaction</label>
            <select id="statutFiltre" name="statutFiltre"
                class="h-[39px] w-[200px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="2">En cours</option>
                <option value="3">Traité</option>
                <option value="4">Livré</option>
                <option value="5">Annulé</option>
                <option value="null" selected>Tous</option>
            </select>
        </div>

        {{-- Filtre de date --}}
        <div class="filter-item">
            <label for="dateFiltre" class="block textPetit-dark font-medium">Date de création</label>
            <select id="dateFiltre" name="dateFiltre" data-url="{{ route('commandesFiltre') }}"
                class="h-[39px] w-[200px] border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="1" selected>Plus récent</option>
                <option value="0">Moins récent</option>
            </select>
        </div>

        <input type="hidden" id="idArtiste" value="{{Auth::id()}}">

        {{-- Clear filtre --}}
        <x-button.red.empty type="submit" id="clearFiltre" value="0" class="w-[200px]">
            Effacer les filtres
        </x-button.red.empty>
    </div>
</div>
