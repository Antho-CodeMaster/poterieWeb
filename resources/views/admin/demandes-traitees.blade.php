<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pt-20 px-20 h-[100%] w-4/5 flex flex-col" x-data="{ openRefuser: false }">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="text-4xl text-black">Demandes traitées</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof($demandes) }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            <!-- Header -->
            <div class="w-[calc(100%-18px)] rounded-[14px] flex items-center p-1 gap-3 mt-4">
                <div class="flex justify-stretch items-center w-11/12">
                    <p class="w-3/12 text-center">Utilisateur</p>
                    <p class="w-2/12 text-center">Date</p>
                    <p class="w-7/12 text-center">Photos (cliquez pour agrandir)</p>
                </div>
                <p class="w-1/12 text-center">Verdict</p>
            </div>
            <div class="flex flex-col grow overflow-auto">
                @if (sizeof($demandes) > 0)
                    @foreach ($demandes as $demande)
                        <div
                            class="demande my-2 w-full h-1/5 bg-lightGrey rounded-[14px] flex justify-between p-1 shrink-0">
                            <div class="flex justify-stretch items-center w-11/12">
                                <div class="flex flex-col w-3/12">
                                    <h1 class="m-auto text-xl">{{ $demande->user->name }}</h1>
                                    <p class="m-auto">{{ $demande->user->email }}</p>
                                    <p class="m-auto">{{ $demande->type->type }}</p>
                                </div>
                                <p class="w-2/12 text-center">{{ $demande->date }}</p>

                                <div class="w-7/12 flex nowrap overflow-x-auto overflow-y-hidden">
                                    @if ($demande->type->type != 'Renouvellement')
                                    <div
                                        class="w-1/2 flex">
                                        @for ($i = 0; $i < 10; $i++)
                                            @if (isset($demande->photos_oeuvres[$i]))
                                                <img src="{{ asset('img/demandePreuve/' . $demande->photos_oeuvres[$i]->path) }}"
                                                    alt="Photo d'oeuvre"
                                                    class="img shadow-md rounded-[16px] cursor-pointer w-1/5 aspect-square object-cover">
                                            @else
                                                <div class="w-1/5">
                                                </div>
                                            @endif
                                        @endfor
                                    </div>
                                    @endif
                                    @if ($demande->type->type != 'Nouveau professionnel')
                                        <div class="w-1/2 flex">
                                            @for ($i = 0; $i < 3; $i++)
                                                @if (isset($demande->photos_identite[$i]))
                                                    <img src="{{ asset('img/demandeIdentite/' . $demande->photos_identite[$i]->path) }}"
                                                        alt="Photo d'identité"
                                                        class="img shadow-md rounded-[16px] cursor-pointer w-1/5 aspect-square object-cover">
                                                @else
                                                    <div class="w-1/5"></div>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="w-1/12 flex justify-center items-center">
                                @if ($demande->id_etat == 2)
                                <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                @elseif($demande->id_etat == 3)
                                <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                  </svg>
                                @else
                                    Erreur
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-3">
                        <svg class="w-24 h-24 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                        </svg>

                        <h2 class="text-4xl">C'est silencieux ici...</h2>
                        <p>Vous n'avez traité aucune demande. Traitez-en une et ce message disparaîtra à jamais!</p>
                    </div>
                @endif
            </div>
            @include('admin.components.image-modal')
        </div>
    </div>
</x-app-layout>
