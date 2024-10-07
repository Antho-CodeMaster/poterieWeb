<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pt-20 px-20 h-[100%] w-4/5 flex flex-col">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="text-4xl text-black">Demandes d'inscription</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof($demandes) }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            {{-- Flèche gauche --}}
            <div class="flex w-full h-full">
                <svg id="prevBtn" class="invisible text-darkGrey cursor-pointer w-[10%] my-auto" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <div class="flex whitespace-nowrap overflow-x-scroll scrollbar-hide w-full">
                    @foreach ($demandes as $demande)
                        <div class="demande hidden flex-col flex-shrink-0 bg-lightGrey rounded-xl w-full h-[90%] my-10">
                            <div class="flex h-[90%]">
                                <div class="w-1/3 h-full text-center">
                                    <svg class="w-[150px] h-[150px] mx-auto text-gray-800 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h1 class="text-3xl">{{ $demande->user->name }}</h1>
                                    <p>Demande créée le {{ $demande->date }}</p>
                                    <p>{{ $demande->user->email }}</p>
                                    <p>{{ $demande->type->type }}</p>
                                </div>
                                <div class="w-2/3 flex flex-col justify-evenly">
                                    <h3 class="text-xl">Photos d'oeuvres réalisées</h3>
                                    <div class="flex w-full">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if (isset($demande->photos_oeuvres[$i]))
                                                <img src="{{asset('storage/app/public/'.$demande->photos_oeuvres[$i]->path)}}"
                                                    alt="Photo d'oeuvre"
                                                    class="shadow-md rounded-[16px] cursor-pointer w-1/5 aspect-square object-cover">
                                            @else
                                                <div class="w-1/5"></div>
                                            @endif
                                        @endfor
                                    </div>
                                    @if ($demande->type->type != 'Nouveau professionnel')
                                        <h3 class="text-xl">Photos d'identité</h3>
                                        <div class="flex w-full">
                                            @for ($i = 0; $i < 3; $i++)
                                                @if (isset($demande->photos_identite[$i]))
                                                    <img src="{{asset('storage/app/public/'.$demande->photos_identite[$i]->path)}}"
                                                        alt="Photo d'identité"
                                                        class="shadow-md rounded-[16px] cursor-pointer w-1/5 aspect-square object-cover">
                                                @else
                                                    <div class="w-1/5"></div>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="flex w-full gap-6 justify-center">
                                @include('admin.components.accepter-button')
                                @include('admin.components.refuser-button')
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Flèche droite --}}

                <svg id="nextBtn" class="text-darkGrey w-[10%] cursor-pointer my-auto" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5 7 7-7 7" />
                </svg>
            </div>
        </div>
    </div>
</x-app-layout>
