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
                        <option value="Modérateur">Modérateurs</option>
                        <option value="Administrateur">Administrateurs</option>
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
                    <div class="user px-4 my-2 w-full h-1/5 bg-lightGrey rounded-[14px] flex p-1 gap-3 shrink-0">
                        <div class="flex justify-stretch items-center w-9/12">
                            <div class="flex flex-col w-1/3">
                                <h3 title="{{ $user->name }}"
                                    class="text-center text-2xl mx-auto text-ellipsis overflow-hidden whitespace-nowrap">
                                    {{ $user->name }}</h3>
                                @if ($user->artiste != null)
                                    <div class="flex w-fit mx-auto" x-data="{ openArtist: {{ $errors->any() ? 'true' : 'false' }} }">
                                        <x-button.blue.leave
                                            @click="
                                            $dispatch('open-artist-modal');
                                            $dispatch('set-name', '{{ $user->name }}');
                                            $dispatch('set-link', '{{ route('kiosque', ['idUser' => $user->id]) }}');
                                            $dispatch('set-artist', '{{ $user->artiste }}');
                                            $dispatch('set-src', '{{ asset($user->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}');
                                            ">Artiste</x-button.blue.leave>
                                    </div>
                                @else
                                    {{-- Si objet modérateur existe --}}
                                    @if ($user->moderateur != null)
                                        {{-- Si utilisateur est admin --}}
                                        @if ($user->moderateur->is_admin)
                                            <p class="m-auto">Administrateur</p>
                                        @else
                                            <p class="m-auto">Modérateur</p>
                                        @endif
                                    @else
                                        <p class="m-auto">Client</p>
                                    @endif
                                @endif
                                <p class="mx-auto">{{ $user->email }}</p>
                            </div>
                            <p class="text-center w-3/12">{{ $user->created_at }}</p>
                            <a href="{{ route('admin-transactions') }}"
                                class="text-center w-1/6">{{ $user->commandes->count() }}</a>
                            <p class="text-center w-1/6">{{ $user->avertissements()->count() }}</p>
                        </div>

                            @if ($user->artiste != null)
                                <p class="mx-auto">Artiste</p>
                                <img src="../img/{{ $user->artiste->path_photo_profil }}" alt="Photo de profil"
                                    class="w-[150px] h-[150px] rounded-full mx-auto">
                                <x-page-access-button
                                    href="{{ route('kiosque', ['idUser' => $user->id]) }}"></x-page-access-button>
                            @else
                                @if ($user->moderateur != null)
                                    @if ($user->moderateur->is_admin != false)
                                        <p class="mx-auto">Administrateur</p>
                                    @else
                                        <p class="mx-auto">Modérateur</p>
                                    @endif
                                @else
                                    <p class="mx-auto">Client</p>
                                @endif
                                <svg class="mb-[3.25rem] w-[150px] h-[150px] mx-auto text-gray-800 dark:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif

                            <div class="flex mx-auto gap-2">
                                <x-avertir-button id="{{ $user->id }}" name="'{{ $user->name }}'">
                                </x-avertir-button>
                                <x-delete-user-button id="{{ $user->id }}" name="'{{ $user->name }}'">
                                </x-delete-user-button>
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
