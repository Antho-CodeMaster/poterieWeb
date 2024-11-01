<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        <div class="w-[84%] p-sectionX h-full flex flex-col">
            <h1 class=" m-titreY titre2-dark p-sectionY border-b-2 border-darkGrey">Mes commandes</h1>

            <div class="grid grid-cols-7 gap-6 grow overflow-auto">
                {{-- Form pour traiter la transaction --}}
                <form action="{{ route('traiterTransaction') }}" method="post" class="col-span-5 gap-input"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- Téléversement des photos --}}
                    <div class="grid m-sectionFormY">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <h2 class="textGrand-dark">Téléversez les photos de livraison</h2>
                                <x-tooltip
                                    text="<ul class='list-disc ml-5'>
                                    <li>Les fichiers téléversés ne peuvent être que de format JPEG, JPG ou PNG</li>
                                    <li>La photo ne doit pas avoir une résolution dépassant 3840 x 2160.</li>
                                  </ul>"
                                    position="bottom" id="1">
                                    <p class="text-[200%]">&#9432;</p>
                                </x-tooltip>
                            </div>
                            <p class="textMoyen-dark text-wrap w-full mb-1 text-justify">Veuillez téléversez jusqu'à 3
                                photos. Ils acteront en tant que
                                preuve
                                de livraison. Assurez-vous que les photos soient prises dans un envirronnement éclairé,
                                bien
                                cadré et à l'intérieur du cadre de la photo.</p>
                        </div>

                        {{-- Input des photos --}}
                        <div class="flex gap-input">

                            @for ($i = 1; $i <= 3; $i++)
                                {{-- Image preview --}}
                                <input type="file" name="photo{{ $i }}" id="photo{{ $i }}"
                                    accept="image/png, image/jpg, image/jpeg" class="hidden">

                                <!-- Conteneur pour l'aperçu de l'image et le bouton de suppression -->
                                <div class="relative flex items-center w-[200px] h-[200px]"
                                    id="previewContainer{{ $i }}">
                                    <!-- Par défaut, le bouton SVG pour déclencher l'upload -->
                                    <button type="button" id="boutonInput{{ $i }}"
                                        onclick="document.getElementById('photo{{ $i }}').click()"
                                        class="w-full h-full">
                                        <svg id="svg{{ $i }}" class="w-full h-full" viewBox="0 0 293 276"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="2.5" y="3.33682" width="288" height="269.43" rx="13.5"
                                                stroke="{{ $errors->has("photo{$i}") ? '#E6AF00' : '#444444' }}"
                                                stroke-width="5" />
                                            <g clip-path="url(#clip0_4003_30)">
                                                <path
                                                    d="M116.667 94.6428C112.477 94.6428 109.083 98.0921 109.083 102.351V164.013C109.083 168.271 112.477 171.72 116.667 171.72H142.009C140.886 169.323 140.103 166.737 139.72 164.013H120.458C118.365 164.013 116.667 162.286 116.667 160.159V150.193C116.667 149.172 117.065 148.189 117.778 147.468L121.569 143.614C123.052 142.107 125.452 142.107 126.931 143.614L139.417 156.305L139.772 155.944C141.767 143.052 152.714 133.182 165.958 133.182C167.248 133.182 168.51 133.309 169.75 133.49V120.958C169.75 118.915 168.95 116.953 167.528 115.508L149.222 96.901C147.8 95.4558 145.87 94.6428 143.86 94.6428H116.667ZM143.208 100.251L164.063 121.62H147C144.907 121.62 143.208 119.893 143.208 117.766V100.251ZM139.417 129.328C141.51 129.328 143.208 131.054 143.208 133.182C143.208 135.309 141.51 137.036 139.417 137.036C137.324 137.036 135.625 135.309 135.625 133.182C135.625 131.054 137.324 129.328 139.417 129.328ZM165.958 140.889C155.49 140.889 147 149.518 147 160.159C147 170.799 155.49 179.428 165.958 179.428C176.427 179.428 184.917 170.799 184.917 160.159C184.917 149.518 176.427 140.889 165.958 140.889ZM165.958 148.597C168.051 148.597 169.75 150.324 169.75 152.451V156.305H173.542C175.635 156.305 177.333 158.031 177.333 160.159C177.333 162.286 175.635 164.013 173.542 164.013H169.75V167.867C169.75 169.994 168.051 171.72 165.958 171.72C163.865 171.72 162.167 169.994 162.167 167.867V164.013H158.375C156.282 164.013 154.583 162.286 154.583 160.159C154.583 158.031 156.282 156.305 158.375 156.305H162.167V152.451C162.167 150.324 163.865 148.597 165.958 148.597Z"
                                                    fill="#444444" />
                                            </g>
                                        </svg>
                                    </button>

                                    <!-- Bouton de suppression -->
                                    <button type="button" id="suppressionBtn{{ $i }}"
                                        class="absolute top-[2px] right-0 hover:scale-125 transition-all duration-[0.2s]">
                                        <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="#e60000" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="3" d="M6 18 17.94 6M18 18 6.06 6" />
                                        </svg>
                                    </button>
                                </div>
                            @endfor

                        </div>
                    </div>

                    {{-- Input du code de référence --}}
                    <div class="grid mb-4">
                        <div class="flex items-center justify-between col-span-4">
                            <h2 class="textGrand-dark">Compagnie de livraison</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'>
                                <li>L'entré est obligatoire</li>
                              </ul>"
                                position="bottom" id="1">
                                <p class="text-[200%]">&#9432;</p>
                            </x-tooltip>
                        </div>
                        <select id="compagnieLivraison" name="compagnieLivraison"
                            class="col-span-4 {{ $errors->has('compagnieLivraison') ? 'color-borderError border-[2px]' : '' }} border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>
                            <option value="" disabled selected hidden>Sélectionner une compagnie de livraison
                            </option>
                            <option value="1">Purolator</option>
                            <option value="2">Postes Canada</option>
                            <option value="3">Fedex</option>
                        </select>
                    </div>

                    {{-- Input du code de référence --}}
                    <div class="grid">
                        <div class="flex items-center justify-between col-span-4">
                            <h2 class="textGrand-dark">Numéro de tracking</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'>
                                <li>L'entré est obligatoire</li>
                              </ul>"
                                position="bottom" id="1">
                                <p class="text-[200%]">&#9432;</p>
                            </x-tooltip>
                        </div>
                        <x-text-input id="codeRefLivraison"
                            class="col-span-4 {{ $errors->has('codeRefLivraison') ? 'color-borderError border-[2px]' : '' }}"
                            type="text" name="codeRefLivraison" required
                            placeholder="Numéro de suivie de la livraison" value="{{ old('codeRefLivraison') }}" />
                    </div>

                    {{-- Input caché de l'id de transaction --}}
                    <input type="hidden" name="idTransaction" value="{{ $transaction->id_transaction }}">

                    {{-- Boutons d'envoie --}}
                    <x-button.green.empty type="submit" id="traiterTransactionBtn" value="confirmer"
                        class="w-full h-[64px] m-submit cursor-pointer bg-vert text-[36px] font-bold text-center">
                        Confirmer
                    </x-button.green.empty>

                </form>
                {{-- Affichage des erreurs/succes/fails --}}
                <div class="col-span-2 mr-1">
                    {{-- Erreur de l'ajout du numéro de tracking --}}
                    @if (Session::has('erreurCodeRefLivraison'))
                        @include('messages.messageFail', [
                            'message' => Session::get('erreurCodeRefLivraison'),
                            'titre' => 'Numéro de tracking',
                        ])
                    @endif

                    {{-- Erreur de l'ajout des photos --}}
                    @if (Session::has('erreurPhotos'))
                        @include('messages.messageFail', [
                            'message' => Session::get('erreurPhotos'),
                            'titre' => 'Photos',
                        ])
                    @endif

                    {{-- Erreur de l'ajout des photos --}}
                    @if (Session::has('erreurCompagnieLivraison'))
                        @include('messages.messageFail', [
                            'message' => Session::get('erreurCompagnieLivraison'),
                            'titre' => 'Compagnie de livraison',
                        ])
                    @endif

                    {{-- Erreur de l'ajout des photos --}}
                    @if (Session::has('erreurEtatTransaction'))
                        @include('messages.messageFail', [
                            'message' => Session::get('erreurEtatTransaction'),
                            'titre' => 'Status de transaction',
                        ])
                    @endif

                    {{-- Erreur de photos --}}
                    @for ($i = 1; $i <= 3; $i++)
                        @if ($errors->has("photo{$i}"))
                            @include('messages.messageError', [
                                'message' => $errors->first("photo{$i}"),
                                'titre' => "Photo $i",
                            ])
                        @endif
                    @endfor

                    @if ($errors->has('compagnieLivraison'))
                        @include('messages.messageError', [
                            'message' => $errors->first("photo{$i}"),
                            'titre' => "Photo $i",
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
