<x-app-layout>
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <div class="pt-20 px-20 w-[90%] h-[100%] flex flex-col" x-data="{ openAvertir: false, openDelete: false, openPromote: false, openDemote: false, openArtist: false }">
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
            <div class="w-[calc(100%-18px)] rounded-[14px] flex items-center p-1 gap-3 mt-4">
                <div class="flex justify-stretch items-center w-9/12">
                    <p class="w-1/3 text-center">Utilisateur</p>
                    <p class="w-3/12 text-center">Inscription</p>
                    <p class="w-1/6 text-center">Commandes</p>
                    <p class="w-1/6 text-center">Avertissements</p>
                </div>
                <p class="w-1/12 text-center">Rôle</p>
                <p class="w-1/6 text-center">Actions</p>
            </div>
            <div class="flex flex-col grow justify-evenly overflow-auto">
                @foreach ($users as $user)
                    <div class="user my-2 w-full h-1/5 bg-lightGrey rounded-[14px] flex p-1 gap-3 shrink-0">
                        <div class="flex justify-stretch items-center w-9/12">

                            <div class="flex flex-col w-1/3">
                                <h3 title="{{ $user->name }}"
                                    class="text-center text-2xl mx-auto text-ellipsis overflow-hidden whitespace-nowrap">
                                    {{ $user->name }}</h3>
                                @if ($user->artiste != null)
                                    <div class="flex w-fit mx-auto x-data="{ openArtist: {{ $errors->any() ? 'true' : 'false' }} }">
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
                        {{-- Div pour les boutons de promotion/rétrogradation --}}
                        <div class="w-1/12 flex flex-col h-full justify-evenly">
                            {{-- Si utilisateur qui consulte est admin --}}
                            @if (Auth::User()->is_admin())
                                {{-- Si utilisateur affiché est client, il sera possible de le promouvoir. --}}
                                @if ($user->moderateur == null && $user->artiste == null)
                                    <div class="h-fit" x-data="{ openPromote: {{ $errors->any() ? 'true' : 'false' }} }">
                                        <x-button.green.award class="w-full"
                                            @click="
                                            $dispatch ('open-promote-modal');
                                            $dispatch('set-id', {{ $user->id }});
                                            $dispatch('set-name', '{{ $user->name }}');
                                            $dispatch('set-role', 0);
                                            ">
                                        </x-button.green.award>
                                    </div>
                                @endif
                                {{-- Si l'utilisateur affiché fait partie de l'administration --}}
                                @if ($user->moderateur != null)
                                    {{-- Si utilisateur affiché n'est pas admin, il sera possible de le promouvoir. --}}
                                    @if (!$user->moderateur->is_admin)
                                        <div class="h-fit" x-data="{ openPromote: {{ $errors->any() ? 'true' : 'false' }} }">
                                            <x-button.green.award class="w-full"
                                                @click="
                                                $dispatch ('open-promote-modal');
                                                $dispatch('set-id', {{ $user->id }});
                                                $dispatch('set-name', '{{ $user->name }}');
                                                $dispatch('set-role', 1);
                                                ">
                                            </x-button.green.award>
                                        </div>
                                    @endif
                                    {{-- Dans tous les cas, il est possible de rétrograder un admin. --}}
                                    <div class="h-fit" x-data="{ openDemote: {{ $errors->any() ? 'true' : 'false' }} }">
                                        <x-button.red.down class="w-full"
                                            @click="
                                            $dispatch('open-demote-modal');
                                            $dispatch('set-id', {{ $user->id }});
                                            $dispatch('set-name', '{{ $user->name }}');
                                            $dispatch('set-role', {{ $user->moderateur->is_admin }});
                                            ">
                                        </x-button.red.down>
                                    </div>
                                @endif
                            @endif
                        </div>
                        {{-- Div pour les boutons de avertir/supprimer --}}
                        <div class="w-1/6 flex flex-col h-full justify-evenly">
                            <div class="h-fit" x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
                                <x-button.red.exclamation class="w-full"
                                    @click="
                                    $dispatch ('open-avertir-modal');
                                    $dispatch('set-id', {{ $user->id }});
                                    $dispatch('set-name', '{{ $user->name }}');
                                    ">Avertir</x-button.red.exclamation>
                            </div>
                            {{-- Si utilisateur qui consulte est admin --}}
                            @if (Auth::User()->is_admin())
                                <div class="h-fit" x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }">
                                    <x-button.red.trash class="w-full"
                                        @click="
                                        $dispatch ('open-delete-modal');
                                        $dispatch('set-id', {{ $user->id }});
                                        $dispatch('set-name', '{{ $user->name }}');
                                        ">Supprimer
                                    </x-button.red.trash>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @include('admin.components.avertir-modal')
            @include('admin.components.delete-modal')
            @include('admin.components.promote-modal')
            @include('admin.components.demote-modal')
            @include('admin.components.artist-modal')
        </div>
    </div>
</x-app-layout>
