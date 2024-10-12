<x-app-layout>
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <div class="pt-20 px-20 w-[90%] h-[100%] flex flex-col" x-data="{ openAvertir: false, openDelete: false }">
            <div id="header-info">
                <h1 class="text-4xl text-black">Utilisateurs</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof($users) }} résultats</h2>

                <div class="flex justify-end">
                    <!-- Sélection du type d'utilisateur -->
                    <select id="type" class="mr-6 border rounded border-black">
                        <option selected value="tous">Tous</option>
                        <option value="Client">Clients</option>
                        <option value="Artiste">Artistes</option>
                        <option value="Administration">Administration</option>
                    </select>

                    <!-- Barre de recherche -->
                    <div id="search-user" class="w-[500px] h-[50px] py-auto flex border rounded border-black">
                        <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                            placeholder="Rechercher par nom..." name="search">
                        <button>
                            <svg class="w-6 h-6 mr-3 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap grow justify-evenly py-4 overflow-auto">
                @foreach ($users as $user)
                    <div class="user my-6 mx-4">
                        <div class="w-[320px] h-[360px] bg-lightGrey rounded-[14px] flex flex-col p-3 gap-3">
                            <h3 title="{{ $user->name }}"
                                class="w-[90%] text-center text-2xl mx-auto text-ellipsis overflow-hidden whitespace-nowrap">
                                {{ $user->name }}</h3>

                            @if ($user->artiste != null)
                                <p class="mx-auto">Artiste</p>
                                <img src="{{ asset($artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                    alt="Photo de profil" class="w-[150px] h-[150px] rounded-full mx-auto">
                                <x-button.blue.leave class="w-full"
                                    @click="window.location.href='{{ route('kiosque', ['idUser' => $user->id]) }}'">Accéder
                                    au kiosque</x-button.blue.leave>
                            @else
                                @if ($user->moderateur != null)
                                    @if ($user->moderateur->is_admin != false)
                                        <p class="mx-auto">Administrateur</p>
                                        @if (Auth::User()->is_admin())
                                            <x-button.red.x class="w-full"
                                                @click="window.location.href='{{ route('admin-user-demote') }}?id={{ $user->id }}'">Rétrograder
                                                modérateur</x-button.red.x>
                                        @endif
                                    @else
                                        <p class="mx-auto">Modérateur</p>
                                        @if (Auth::User()->is_admin())
                                            <x-button.green.award class="w-full"
                                                @click="window.location.href='{{ route('admin-user-promote') }}?id={{ $user->id }}'">Rendre
                                                administrateur</x-button.green.award>
                                            <x-button.red.x class="w-full"
                                                @click="window.location.href='{{ route('admin-user-demote') }}?id={{ $user->id }}'">Rétrograder
                                                client</x-button.red.x>
                                        @endif
                                    @endif
                                @else
                                    <p class="mx-auto">Client</p>
                                    <p class="mx-auto">{{ $user->email }}</p>
                                    <p class="mx-auto">Inscription: {{ $user->created_at }}</p>
                                    <p class="mx-auto">{{ $user->commandes->count() }}
                                        commande{{ $user->commandes->count() == 1 ? '' : 's' }}</p>
                                    <p class="mx-auto">{{ $user->avertissements()->count() }}
                                        avertissement{{ $user->avertissements()->count() == 1 ? '' : 's' }}</p>
                                    @if (Auth::User()->is_admin())
                                        <x-button.green.award class="w-full"
                                            @click="window.location.href='{{ route('admin-user-promote') }}?id={{ $user->id }}'">Rendre
                                            modérateur</x-button.green.award>
                                    @endif
                                @endif
                            @endif
                            <div class="flex mx-auto gap-2 w-full">
                                <div x-cloak x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }"
                                    class='{{ Auth::User()->is_admin() ? 'w-[45%]' : 'w-full' }}'>
                                    <x-button.red.exclamation class="w-full"
                                        @click="openAvertir = true; $dispatch ('open-avertir-modal'); $dispatch('set-id', {{ $user->id }}); $dispatch('set-name', '{{ $user->name }}');">Avertir</x-button.red.exclamation>
                                </div>
                                @if (Auth::User()->is_admin())
                                    <div x-cloak x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }" class="w-[55%]">
                                        <x-button.red.trash class="w-full"
                                            @click="openDelete = true; $dispatch ('open-delete-modal'); $dispatch('set-id', {{ $user->id }}); $dispatch('set-name', '{{ $user->name }}');">Supprimer
                                        </x-button.red.trash>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('admin.components.avertir-modal')
            @include('admin.components.delete-modal')
        </div>
    </div>
</x-app-layout>
