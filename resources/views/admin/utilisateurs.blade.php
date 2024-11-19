<x-app-layout>
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <div class="pr-10 w-[90%] h-[100%] flex flex-col" x-data="{ openAvertir: false, openDelete: false, openPromote: false, openDemote: false, openArtist: false }">
            <div id="header-info">
                <div class="flex border-b-2 border-darkGrey gap-5 justify-between">
                    <h1 class="titre2-dark m-titreY p-sectionY">Utilisateurs</h1>
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
                            <p class="pageLink cursor-pointer px-4 py-2 rounded
                        {{ $page + 1 == $i ? 'bg-darkGrey text-white' : '' }}">
                                {{ $i }}</p>
                        @endfor
                        @if ($page + 3 < $total_pages)
                            <p>...</p>
                        @endif
                        <p class="pageLink cursor-pointer px-4 py-2 rounded
                    {{ $page + 1 == $total_pages ? 'bg-darkGrey text-white' : '' }}">
                            {{ $total_pages }}</p>
                    </div>
                </div>
                <h2 class="text-2xl text-darkGrey">{{ $page * 50 + 1 }} à
                    {{ ($page * 50 + 50) > $count ? $count : ($page * 50 + 50)}} de {{ $count }} résultats</h2>

                <form method="get" action="{{route('admin-utilisateurs')}}" class="flex justify-end" id="filterForm">
                    <input id="pageID" type="hidden" name="page" value="1">
                    <!-- Sélection du type d'utilisateur -->
                    <select id="type" name="type" class="mr-6 border rounded border-black">
                        <option {{$type == "tous" || $type == null || $type == '' ? 'selected' : '' }} value="tous">Tous</option>
                        <option {{$type == "Client" ? 'selected' : '' }} value="Client">Clients</option>
                        <option {{$type == "Artiste" ? 'selected' : '' }} value="Artiste">Artistes</option>
                        <option {{$type == "Administration" ? 'selected' : '' }} value="Administration">Administration</option>
                    </select>

                    <!-- Barre de recherche -->
                    <div id="search-user" class="w-[500px] h-[50px] py-auto flex border rounded border-black">
                        <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text"
                            placeholder="Rechercher par nom / par e-mail..." name="query" value="{{$query}}">
                        <button>
                            <svg class="w-6 h-6 mr-3 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Header -->
            <div class="w-[calc(100%-18px)] px-4 rounded-[14px] flex items-center p-1 gap-3 mt-4">
                <div class="flex justify-stretch items-center w-9/12">
                    <p class="w-1/3 text-center">Utilisateur</p>
                    <p class="w-3/12 text-center">Inscription</p>
                    <p class="w-1/6 text-center">Commandes</p>
                    <p class="w-1/6 text-center">Avertissements</p>
                </div>
                <p class="w-1/12 text-center">Rôle</p>
                <p class="w-1/6 text-center">Actions</p>
            </div>
            <div class="flex flex-col grow overflow-auto">
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
                            <a href="{{ route('admin-commandes') }}"
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
                                            <x-button.green.award class="w-1/2 mx-auto"
                                                @click="
                                            $dispatch('open-promote-modal');
                                            $dispatch('set-id', {{ $user->id }});
                                            $dispatch('set-name', '{{ $user->name }}');
                                            $dispatch('set-role', 0);
                                            ">
                                            </x-button.green.award>
                                        </div>
                                        <div class="h-10"></div>
                                    @endif
                                    {{-- Si l'utilisateur affiché fait partie de l'administration --}}
                                    @if ($user->moderateur != null)
                                        {{-- Si utilisateur affiché n'est pas admin, il sera possible de le promouvoir. --}}
                                        @if (!$user->moderateur->is_admin)
                                            <div class="h-fit" x-data="{ openPromote: {{ $errors->any() ? 'true' : 'false' }} }">
                                                <x-button.green.award class="w-1/2 mx-auto"
                                                    @click="
                                                $dispatch('open-promote-modal');
                                                $dispatch('set-id', {{ $user->id }});
                                                $dispatch('set-name', '{{ $user->name }}');
                                                $dispatch('set-role', 1);
                                                ">
                                                </x-button.green.award>
                                            </div>
                                        @else
                                            <div class="h-10"></div>
                                        @endif
                                        {{-- Dans tous les cas, il est possible de rétrograder un admin. --}}
                                        <div class="h-fit" x-data="{ openDemote: {{ $errors->any() ? 'true' : 'false' }} }">
                                            <x-button.red.down class="w-1/2 mx-auto"
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
                        {{-- Si l'utilisateur affiché == utilisateur connecté, on ne peut pas  avertir/supprimer --}}
                        @if (Auth::id() != $user->id)
                            {{-- Div pour les boutons de avertir/supprimer --}}
                            <div class="w-1/6 flex flex-col h-full justify-evenly">
                                <div class="h-fit" x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
                                    <x-button.yellow.exclamation class="w-full"
                                        @click="
                                    $dispatch('open-avertir-modal');
                                    $dispatch('set-id', {{ $user->id }});
                                    $dispatch('set-name', '{{ $user->name }}');
                                    ">Avertir</x-button.yellow.exclamation>
                                </div>
                                {{-- Si utilisateur qui consulte est admin --}}
                                @if (Auth::User()->is_admin())
                                    <div class="h-fit" x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }">
                                        <x-button.red.trash class="w-full"
                                            @click="
                                        $dispatch('open-delete-modal');
                                        $dispatch('set-id', {{ $user->id }});
                                        $dispatch('set-name', '{{ $user->name }}');
                                        ">Supprimer
                                        </x-button.red.trash>
                                    </div>
                                @endif
                            </div>
                            @else
                            <div class="w-1/6 h-full flex items-center justify-center"><p class="text-center">Vous</p></div>
                        @endif
                    </div>
                @endforeach
            </div>
            @include('admin.components.avertir-modal')
            @include('admin.components.delete-user-modal')
            @include('admin.components.promote-modal')
            @include('admin.components.demote-modal')
            @include('admin.components.artist-modal')
        </div>
    </div>
</x-app-layout>
