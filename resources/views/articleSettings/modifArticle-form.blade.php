<x-app-layout>
    <div class="flex content-height">
        @include('articleSettings.articleSettings-sideMenu')

        {{-- Gestion des borders en fonctions des erreurs --}}


        <div class=" w-[84%] p-sectionX p-sectionBottom h-full flex flex-col">
            <h1 class="titre2-dark p-sectionY border-b-2 border-darkGrey ">Modification d'un article</h1>

            <div class="grid grid-cols-7 gap-6 grow overflow-auto">
                <form method="post" action="{{ route('modifArticle') }}" id="modifArticleForm"
                    enctype="multipart/form-data" class="col-span-5">
                    @csrf
                    @method('PATCH')

                    {{-- Téléversement des photos --}}
                    <div class="m-sectionFormY">
                        <div class="flex items-center justify-between">
                            <h2 class="textGrand-dark">Téléversez les photos de l'article</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'>
                                        <li>Les fichiers téléversés ne peuvent être que de format JPEG, JPG ou PNG</li>
                                        <li>La photo ne doit pas avoir une résolution .</li>
                                      </ul>"
                                position="bottom" id="1">
                                <p class="text-[200%]">&#9432;</p>
                            </x-tooltip>
                        </div>
                        <div class="flex gap-input">
                            @for ($i = 1; $i <= 5; $i++)
                                {{-- Définir une classe pour la bordure en fonction des erreurs --}}
                                @php
                                    $erreurPhoto = $errors->has("photo{$i}")
                                        ? 'border-jauneWarning'
                                        : 'border-darkGrey';
                                @endphp

                                {{-- Input de fichier --}}
                                <input type="file" name="photo{{ $i }}" id="photo{{ $i }}"
                                    accept="image/png, image/jpg, image/jpeg" class="hidden"
                                    onchange="previewImage(event, {{ $i }})"
                                    @if (isset($article->photo_article[$i - 1]->id_photo)) {value="{{ $article->photo_article[$i - 1]->path }}"} @endif>

                                {{-- Champ caché pour l'ID de la photo --}}
                                @if (isset($article->photo_article[$i - 1]->id_photo))
                                    <input type="hidden" name="photoId{{ $i }}"
                                        value="{{ $article->photo_article[$i - 1]->id_photo }}">
                                @endif

                                {{-- Bouton ou l'image à prévisualiser --}}
                                <button type="button"
                                    onclick="document.getElementById('photo{{ $i }}').click()"
                                    class="flex items-center w-[100px] h-[100px]"
                                    id="previewContainer{{ $i }}">

                                    @if (isset($article->photo_article[$i - 1]->path))
                                        {{-- Afficher l'image si elle existe --}}
                                        <img src="/../img/{{ $article->photo_article[$i - 1]->path }}"
                                            {{-- Probleme au niveau de l'insertion des photos (le path est identique entre plusieurs photo) --}} alt="Image {{ $i }}"
                                            class="w-[100px] h-[96px] object-cover border-[2px] {{ $erreurPhoto }} rounded-[0.375rem]"
                                            id="imgPreview{{ $i }}">
                                    @else
                                        {{-- Afficher le SVG par défaut si aucune image --}}
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
                                    @endif
                                </button>
                            @endfor
                        </div>
                    </div>

                    {{-- Identifiant de l'article --}}
                    <div class="m-sectionFormY">
                        <div class="flex items-center justify-between">
                            <h2 class="textGrand-dark">Identifiant de l'article</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'><li>Le nom et le prix doivent être remplis.
                                        </li><li>Les mots clés doivent commencés par un '#' et ne contenir aucun espace.
                                        </li><li>La description n'est pas obligatoire mais fortement recommandée.</li>
                                      </ul>"
                                position="left" id="1">
                                <p class="text-[200%]">&#9432</p>
                            </x-tooltip>
                        </div>
                        <div class="grid gap-input">
                            <div class="grid grid-cols-4 gap-input">
                                <!-- Nom Article -->
                                <x-text-input id="nomArticle"
                                    class="col-span-2 {{ $errors->has('nomArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                    type="text" name="nomArticle" placeholder="Nom de l'article"
                                    value="{{ $article->nom }}" />

                                <!-- Prix Article -->
                                <x-text-input id="prixArticle"
                                    class="col-span-2 {{ $errors->has('prixArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                    type="number" name="prixArticle" required step="0.01" min="0"
                                    placeholder="Prix ($)" value="{{ $article->prix }}" />
                            </div>

                            <div class="grid grid-cols-4 gap-input">
                                <!-- Description de l'article -->
                                <textarea id="descriptionArticle" name="descriptionArticle"
                                    class="resize-none col-span-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 {{ $errors->has('descriptionArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                    placeholder="Description">{{ $article->description }}</textarea>

                                <textarea id="motClesArticle" name="motClesArticle" rows="2"
                                    class="resize-none col-span-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 {{ $errors->has('motClesArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                    placeholder="#Funky#MeilleurArticleEver#Automne#Aussiété">{{ $article->motCles->isNotEmpty() ? '#' . $article->motCles->pluck('mot_cle')->implode('#') : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Dimensions et poids --}}
                    <div class="m-sectionFormY">
                        <div class="flex items-center justify-between">
                            <h2 class="textGrand-dark">Dimensions et poids de l'article</h2>
                            <x-tooltip
                                text="Les dimensions doivent être inscrit en cm et ne peuvent être plus petit que 0,1cm."
                                position="left" id="1">
                                <p class="text-[200%]">&#9432</p>
                            </x-tooltip>
                        </div>

                        <div class="grid grid-cols-2 grid-rows-2 gap-input">
                            {{-- Profondeur --}}
                            <x-text-input id="profondeurArticle"
                                class="col-span-1 {{ $errors->has('profondeurArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                type="number" name="profondeurArticle" placeholder="Profondeur (cm)" min="0"
                                required value="{{ $article->profondeur }}" step="0.01" />

                            {{-- Hauteur --}}
                            <x-text-input id="hauteurArticle"
                                class="col-span-1 {{ $errors->has('hauteurArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                type="number" name="hauteurArticle" placeholder="Hauteur (cm)" min="0" required
                                value="{{ $article->hauteur }}" step="0.01" />

                            {{-- Largeur --}}
                            <x-text-input id="largeurArticle"
                                class="col-span-1 {{ $errors->has('largeurArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                type="number" name="largeurArticle" placeholder="Largeur (cm)" min="0"
                                required value="{{ $article->largeur }}" step="0.01" />

                            {{-- Poids --}}
                            <x-text-input id="poidsArticle"
                                class="col-span-1 {{ $errors->has('poidsArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                                type="number" name="poidsArticle" placeholder="Poids (g)" min="0" required
                                value="{{ $article->poids }}" step="0.01" />
                        </div>
                    </div>

                    {{-- Type de pièce et usage alimentaire --}}
                    <div class="m-sectionFormY">
                        <div class="flex items-center justify-between w-full">
                            <h2 class="textGrand-dark">Type de pièce et usage alimentaire</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'><li>Le type d'usage permet de déterminer si l'article peut être utilisé à des fins alimentaires.
                                            </li><li>Le type de pièce permet de savoir si l'article est une œuvre d'art ou un article en série.
                                            </li><li>Si la pièce est unique alors la quantité de l'article sera obligatoirement de 1.</li>
                                          </ul>"
                                position="left" id="1">
                                <p class="text-[200%]">&#9432;</p>
                            </x-tooltip>
                        </div>
                        <div class="grid grid-cols-2 grid-rows-2 gap-input">

                            <!-- IsAlimentaire -->
                            <select id="typePiece" name="typePiece" required
                                class="col-span-2 row-span-1 {{ $errors->has('typePiece') ? 'border-jauneWarning border-[2px]' : '' }} border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected hidden>Sélectionner un type d'usage
                                </option>
                                <option value="1" {{ $article->typePiece == 1 ? 'selected' : '' }}>
                                    Alimentaire</option>
                                <option value="0" {{ $article->typePiece == 0 ? 'selected' : '' }}>
                                    Non-alimentaire</option>
                            </select>

                            {{-- IsUnique --}}
                            <select id="pieceUnique" name="pieceUnique"
                                class="col-span-2 {{ $errors->has('pieceUnique') ? 'border-jauneWarning border-[2px]' : '' }} border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="" disabled selected hidden>Sélectionner un type de pièce
                                </option>
                                <option value="1" {{ $article->is_unique == 1 ? 'selected' : '' }}>
                                    Unique
                                </option>
                                <option value="0" {{ $article->is_unique == 0 ? 'selected' : '' }}> En
                                    série
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class=" m-sectionFormY">
                        <div class="flex items-center justify-between">
                            <h2 class="textGrand-dark">Attributs de l'article</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'>
                                            <li>Le bouton masqué empêche les utilisateurs clients d'avoir accès à cet article.</li>
                                            <li>Le bouton en vedette permet à cet article d'être mis en avant sur votre kiosque personnel.</li>
                                            <li>Le bouton flouté floutera cette image aux yeux des utilisateurs qui ont activé la sensibilité sur le site.</li>
                                          </ul>"
                                position="left" id="1">
                                <p class="text-[200%]">&#9432;</p>
                            </x-tooltip>
                        </div>

                        <div class="grid grid-cols-2 gap-input">
                            {{-- masquer --}}
                            <input type="hidden" name="masquer" value="1" />
                            <input type="checkbox" name="masquer" id="masquerBtn" value="2" class="hidden"
                                {{ $article->id_etat == 2 ? 'checked' : '' }} />
                            <label for="masquerBtn" title="Ceci permet de masquer l'article aux yeux des clients"
                                class="col-span-1 cursor-pointer border-[1px] shadow border-gray-200 text-darkGrey font-bold py-2 text-center rounded-[0.375rem] transition duration-200 ease-in-out hover:bg-beige checked:bg-[#ebe3dc] checked:text-darkGrey">
                                Masquer
                            </label>

                            {{-- flouter --}}
                            <input type="hidden" name="flouter" value="0" />
                            <input type="checkbox" name="flouter" id="flouterBtn" value="1" class="hidden"
                                {{ $article->is_sensible == 1 ? 'checked' : '' }} />
                            <label for="flouterBtn"
                                title="Ceci floutera l'image de l'article aux yeux des clients sensibles"
                                class="col-span-1 cursor-pointer border-[1px] shadow border-gray-200 text-darkGrey font-bold py-2 text-center rounded-[0.375rem] transition duration-200 ease-in-out hover:bg-beige checked:bg-[#ebe3dc] checked:text-darkGrey">
                                Flouter (+18)
                            </label>

                            {{-- En vedette --}}
                            <input type="hidden" name="enVedette" value="0" />
                            <input type="checkbox" name="enVedette" id="enVedetteBtn" value="1" class="hidden"
                                {{ $article->is_en_vedette == 1 ? 'checked' : '' }} />
                            <label for="enVedetteBtn" title="Ceci placera cette article dans votre section en vedette"
                                class="col-span-2 cursor-pointer border-[1px] shadow border-gray-200 text-darkGrey font-bold py-2 text-center rounded-[0.375rem] transition duration-200 ease-in-out hover:bg-beige checked:bg-[#ebe3dc] checked:text-darkGrey">
                                En vedette
                            </label>
                        </div>
                    </div>

                    {{-- Quantité --}}
                    <div class="">
                        <div class="flex items-center justify-between">
                            <h2 class="textGrand-dark" id="titreQuantite">Quantité d'article en vente</h2>
                            <x-tooltip
                                text="<ul class='list-disc ml-5'>
                                            <li>La quantité de l'article en vente ne pourra pas être de 0.</li>
                                            <li>Une quantité de 1 ne signifie pas qu'il sera considérer en tant qu'article unique. Pour cela il faut ajuster le type de pièce.</li>
                                          </ul>"
                                position="left" id="1">
                                <p class="text-[200%]">&#9432;</p>
                            </x-tooltip>
                        </div>

                        <x-text-input id="quantiteArticle"
                            class="w-full {{ $errors->has('quantiteArticle') ? 'border-jauneWarning border-[2px]' : '' }}"
                            type="number" name="quantiteArticle" placeholder="Quantité en vente" step="1"
                            min="1" max="9999" required value="{{ $article->quantite_disponible }}" />

                    </div>

                    <input type="hidden" name="idArtiste" value="{{ $artiste->id_artiste }}">
                    <input type="hidden" name="idArticle" value="{{ $article->id_article }}">

                    {{-- Boutons d'envoie --}}
                    <x-button.green.empty type="submit" id="addArticleBtn" value="confirmer"
                        class="w-full h-[64px] m-submit cursor-pointer bg-vert text-[36px] font-bold text-center">
                        Modifier article
                    </x-button.green.empty>
                </form>

                {{-- Affichage des erreurs/succes/fails --}}
                <div class="col-span-2 mr-1">

                    {{-- Succes de l'ajout d'un article --}}
                    @if (Session::has('succesArticle'))
                        @include('messages.messageSucces', [
                            'message' => Session::get('succesArticle'),
                            'titre' => 'Modification',
                        ])
                    @endif

                    {{-- Erreur de l'ajout des mots clés --}}
                    @if (Session::has('erreurMotcles'))
                        @include('messages.messageFail', [
                            'message' => Session::get('erreurMotcles'),
                            'titre' => 'Mots Clés',
                        ])
                    @endif

                    {{-- Erreur de l'ajout des photos --}}
                    @if (Session::has('erreurPhotos'))
                        @include('messages.messageFail', [
                            'message' => Session::get('erreurPhotos'),
                            'titre' => 'Photos',
                        ])
                    @endif

                    {{-- Erreur de photos --}}
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($errors->has("photo{$i}"))
                            @include('messages.messageError', [
                                'message' => $errors->first("photo{$i}"),
                                'titre' => "Photo $i",
                            ])
                        @endif
                    @endfor

                    {{-- Erreur dans le nom --}}
                    @if ($errors->has('nomArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('nomArticle'),
                            'titre' => 'Nom',
                        ])
                    @endif

                    {{-- Erreur dans le prix --}}
                    @if ($errors->has('prixArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('prixArticle'),
                            'titre' => 'Prix',
                        ])
                    @endif

                    @if ($errors->has('descriptionArticle'))
                        {{-- Erreur dans la description --}}
                        @include('messages.messageError', [
                            'message' => $errors->first('descriptionArticle'),
                            'titre' => 'Description',
                        ])
                    @endif

                    {{-- Erreur dans les mots clés --}}
                    @if ($errors->has('motClesArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('motClesArticle'),
                            'titre' => 'Mots clés',
                        ])
                    @endif

                    {{-- Erreur dans la hauteur --}}
                    @if ($errors->has('hauteurArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('hauteurArticle'),
                            'titre' => 'Hauteur',
                        ])
                    @endif

                    {{-- Erreur dans la largeur --}}
                    @if ($errors->has('largeurArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('largeurArticle'),
                            'titre' => 'Largeur',
                        ])
                    @endif

                    {{-- Erreur dans la profondeur --}}
                    @if ($errors->has('profondeurArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('profondeurArticle'),
                            'titre' => 'Profondeur',
                        ])
                    @endif

                    {{-- Erreur dans la largeur --}}
                    @if ($errors->has('poidsArticle'))
                        @include('messages.messageError', [
                            'message' => $errors->first('poidsArticle'),
                            'titre' => 'Poids',
                        ])
                    @endif

                    {{-- Erreur dans la largeur --}}
                    @if ($errors->has('typePiece'))
                        @include('messages.messageError', [
                            'message' => $errors->first('typePiece'),
                            'titre' => 'Type d\'usage',
                        ])
                    @endif

                    {{-- Erreur dans la largeur --}}
                    @if ($errors->has('pieceUnique'))
                        @include('messages.messageError', [
                            'message' => $errors->first('pieceUnique'),
                            'titre' => 'Type de pièce',
                        ])
                    @endif
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
