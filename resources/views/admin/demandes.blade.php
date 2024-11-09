<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] w-4/5 flex flex-col" x-data="{ openRefuser: false }">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info" class="flex justify-between">
                <div>
                    <h1 class="titre2-dark m-titreY p-sectionY border-b-2 border-darkGrey">Demandes d'inscription</h1>
                    <h2 class="text-2xl text-darkGrey">{{ sizeof($demandes) }} résultats</h2>
                </div>
                <div class="flex items-center justify-center">
                    <x-button.blue.clipboard-check
                        @click="window.location.href='{{ route('admin-demandes-traitees') }}'">Demandes
                        traitées</x-button.blue.clipboard-check>
                </div>
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
                    @if (sizeof($demandes) > 0)
                        @foreach ($demandes as $demande)
                            <div
                                class="demande select-none hidden flex-col flex-shrink-0 bg-lightGrey rounded-xl w-full h-[90%] my-10 p-2">
                                <div class="flex h-[90%]">
                                    <div class="w-1/3 h-full text-center">
                                        <svg class="w-[150px] h-[150px] mx-auto text-gray-800 dark:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <h1 class="text-3xl text-ellipsis overflow-hidden whitespace-nowrap">
                                            {{ $demande->user->name }}</h1>
                                        <p>Demande créée le {{ $demande->date }}</p>
                                        <p>{{ $demande->user->email }}</p>
                                        <p>{{ $demande->type->type }}</p>
                                    </div>
                                    <div
                                        class="w-2/3 flex flex-col {{ $demande->type->type == 'Nouvel étudiant' ? 'justify-evenly' : 'justify-start' }}">
                                        @if ($demande->type->type != 'Renouvellement')
                                            <div>
                                                <h3 class="text-xl mb-4">Photos d'oeuvres réalisées</h3>
                                                <div class="flex w-full flex-wrap gap-2">
                                                    @for ($i = 0; $i < 10; $i++)
                                                        @if (isset($demande->photos_oeuvres[$i]))
                                                            <img src="{{ asset('img/demandePreuve/' . $demande->photos_oeuvres[$i]->path) }}"
                                                                alt="Photo d'oeuvre"
                                                                class="img shadow-md rounded-[16px] cursor-pointer w-[19%] aspect-square object-cover">
                                                        @else
                                                            <div class="w-[19%]">
                                                            </div>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        @endif
                                        @if ($demande->type->type != 'Nouveau professionnel')
                                            <div>
                                                <h3 class="text-xl mb-4">Photos d'identité</h3>
                                                <div class="flex w-full gap-2">
                                                    @for ($i = 0; $i < 3; $i++)
                                                        @if (isset($demande->photos_identite[$i]))
                                                            <img src="{{ asset('img/demandeIdentite/' . $demande->photos_identite[$i]->path) }}"
                                                                alt="Photo d'identité"
                                                                class="img shadow-md rounded-[16px] cursor-pointer w-[19%] aspect-square object-cover">
                                                        @else
                                                            <div class="w-[19%]"></div>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="flex w-full gap-6 justify-center">
                                    <form method="POST"
                                        action="{{ route('demande-accept') }}?id={{ $demande->id_demande }}">
                                        @csrf
                                        <x-button.green.check>Accepter</x-button.green.check>
                                    </form>
                                    <div x-data="{ openRefuser: {{ $errors->any() ? 'true' : 'false' }} }">
                                        <x-button.red.x class="w-full"
                                            @click="openRefuser = true; $dispatch ('open-refuser-modal'); $dispatch('set-id', {{ $demande->id_demande }}); $dispatch('set-name', '{{ $demande->user->name }}');">Refuser</x-button.red.x>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="w-full flex flex-col items-center justify-center gap-3">
                            <svg class="w-24 h-24 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                            </svg>

                            <h2 class="text-4xl">C'est silencieux ici...</h2>
                            <p>Vous avez traité toutes les demandes. Vous pouvez enfin vous reposer!</p>
                        </div>
                    @endif
                </div>
                {{-- Flèche droite --}}

                <svg id="nextBtn" class="invisible text-darkGrey w-[10%] cursor-pointer my-auto" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="4 4 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5 7 7-7 7" />
                </svg>
            </div>
            @include('admin.components.image-modal')
            @include('admin.components.refuser-modal')
            {{-- Si toute autre erreur --}}
            @if ($errors->has('error'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageError', [
                        'message' => $errors->first('error'),
                        'titre' => 'Erreur',
                    ])
                </div>
            @endif
            @if ($errors->has('refus'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageError', [
                        'message' => $errors->first('refus'),
                        'titre' => 'Paiement refusé',
                    ])
                </div>
            @endif
            {{-- Si toute autre erreur --}}
            @if ($errors->has('fail'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageFail', [
                        'message' => $errors->first('fail'),
                        'titre' => 'Échec',
                    ])
                </div>
            @endif
            {{-- Si toute autre erreur --}}
            @if (Session::has('succes'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageSucces', [
                        'message' => Session::get('succes'),
                        'titre' => 'Succès',
                    ])
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
