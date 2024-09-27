<x-app-layout>
    <div class="flex">
        @include('admin.menu-gauche')
        <div class="pt-20 pl-20 w-[80%]">
            <h1 class="text-4xl text-black">Utilisateurs</h1>
            <h2 class="text-2xl text-darkGrey">{{ sizeof($users) }} résultats</h2>

            <!-- Barre de recherche -->
            <div class="mr-0 w-[500px] border rounded border-black">
                <form action="" class="w-full h-[38px] py-auto flex"> {{-- Il faut remplir l'action --}}
                    <input class="w-full border-0 focus:border-0 focus:shadow-none rounded h-full" type="text" placeholder="Rechercher..."
                        name="search">
                    <button type="submit">
                        <svg class="w-6 h-6 mr-3 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="flex flex-wrap h-[100%] gap-x-[5%] gap-y-10 pt-16">
                @foreach ($users as $user)
                        <div class="w-[320px] h-[360px] bg-lightGrey rounded-[14px] flex flex-col p-3 gap-3">
                            <h3 class="text-2xl mx-auto">{{ $user->name }}</h3>

                            @if ($user->artiste != null)
                                <p class="mx-auto">Artiste</p>
                                <img src="../img/{{ $user->artiste->path_photo_profil }}" alt="Photo de profil"
                                    class="w-[150px] h-[150px] rounded-full mx-auto">
                                <x-page-access-button
                                    href="{{ #route('kiosque/' . $user->id)
                                        route('decouverte') }}"></x-page-access-button>
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
                                @include('admin.components.avertir-button')
                                <x-delete-user-button href="{{ route('admin-user-delete', ['id' => $user->id]) }}"></x-delete-user-button>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
