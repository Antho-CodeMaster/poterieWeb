<x-app-layout>
    <div class="flex content-height">
        @include('components.articleSettings-sideMenu')

        <div class=" w-[84%] p-3 grow overflow-auto">
            <h1 class="titre2 p-1 border-b-2 border-darkGrey mb-2">Modification d'un article</h1>

            <div class="grid grid-cols-7 gap-6 grow overflow-auto">
                <form method="post" action="{{ route('modifArticle') }}" id="modifArticleForm"
                    enctype="multipart/form-data" class="col-span-5">
                    @csrf
                    @method("PATCH")

                    {{-- Téléversement des photos --}}
                    <div class="grid gap-2 mb-6">
                        <h2 class="text-[120%]">Téléversez les photos de l'article</h2>
                        <div class="flex gap-2">
                            @for ($i = 1; $i <= 5; $i++)
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
                                            class="w-[100px] h-[96px] object-cover border-[2px] border-darkGrey rounded-[0.375rem]"
                                            id="imgPreview{{ $i }}">
                                    @else
                                        {{-- Afficher le SVG par défaut si aucune image --}}
                                        <svg id="svg{{ $i }}" class="w-full h-full" viewBox="0 0 293 276"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="2.5" y="3.33682" width="288" height="269.43" rx="13.5"
                                                stroke="#444444" stroke-width="5" />
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
                    <div class="grid gap-2 mb-6">
                        <h2 class="text-[120%]">Identifiant de l'article</h2>
                        <div class="grid grid-cols-4 gap-2">
                            <!-- Nom Article -->
                            <x-text-input id="nomArticle" class="col-span-2" type="text" name="nomArticle" required
                                placeholder="Nom de l'article" value="{{ $article->nom }}" />

                            <!-- Prix Article -->
                            <x-text-input id="prixArticle" class="col-span-2" type="number" name="prixArticle" required
                                step="0.01" min="0" placeholder="Prix ($)" value="{{ $article->prix }}" />
                        </div>

                        <div class="grid grid-cols-4 gap-2">
                            <!-- Description de l'article -->
                            <textarea id="descriptionArticle" name="descriptionArticle"
                                class="col-span-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Description" required>{{ $article->description }}</textarea>

                            <!-- Mots-clés -->
                            <textarea id="motClesArticle" name="motClesArticle" rows="2"
                                class="col-span-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="#Funky#MeilleurArticleEver#Automne#Aussiété">{{ $article->motCles->isNotEmpty() ? '#' . $article->motCles->pluck('mot_cle')->implode('#') : '' }}
                            </textarea></textarea>
                        </div>
                    </div>


                    <div class="grid grid-cols-2 gap-4 mb-6">

                        {{-- Dimensions et poids --}}
                        <div class="grid col-span-1 gap-2">
                            <h2 class="text-[120%]">Dimensions et poids de l'article</h2>
                            <div class="grid grid-cols-2 grid-rows-2 gap-2">

                                {{-- Profondeur --}}
                                <x-text-input id="profondeurArticle" class="col-span-1" type="number"
                                    name="profondeurArticle" placeholder="Profondeur (cm)" min="0" required
                                    value="{{ $article->profondeur }}" step="0.01" />

                                {{-- Hauteur --}}
                                <x-text-input id="hauteurArticle" class="col-span-1" type="number"
                                    name="hauteurArticle" placeholder="Hauteur (cm)" min="0" required
                                    value="{{ $article->hauteur }}" step="0.01" />

                                {{-- Largeur --}}
                                <x-text-input id="largeurArticle" class="col-span-1" type="number"
                                    name="largeurArticle" placeholder="Largeur (cm)" min="0" required
                                    value="{{ $article->largeur }}" step="0.01" />

                                {{-- Poids --}}
                                <x-text-input id="poidsArticle" class="col-span-1" type="number" name="poidsArticle"
                                    placeholder="Poids (g)" min="0" required value="{{ $article->poids }}"
                                    step="0.01" />
                            </div>
                        </div>

                        {{-- Type de pièce et usage alimentaire --}}
                        <div class="grid col-span-1 gap-2">
                            <h2 class="text-[120%]">Type de pièce et usage alimentaire</h2>
                            <div class="grid grid-cols-2 grid-rows-2 gap-2">

                                <!-- IsAlimentaire -->
                                <select id="typePiece" name="typePiece" required
                                    class="col-span-2 row-span-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" disabled selected hidden>Sélectionner un type d'usage
                                    </option>
                                    <option value="1" {{ $article->typePiece == 1 ? 'selected' : '' }}>
                                        Alimentaire</option>
                                    <option value="0" {{ $article->typePiece == 0 ? 'selected' : '' }}>
                                        Non-alimentaire</option>
                                </select>

                                {{-- IsUnique --}}
                                <select id="pieceUnique" name="pieceUnique"
                                    class="col-span-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                                    <option value="" disabled selected hidden>Sélectionner un type de pièce
                                    </option>
                                    <option value="1" {{ $article->is_unique == 1 ? 'selected' : '' }}> Unique
                                    </option>
                                    <option value="0" {{ $article->is_unique == 0 ? 'selected' : '' }}> En série
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">

                        {{-- Dimensions et poids --}}
                        <div class="grid col-span-1 gap-2">
                            <h2 class="text-[120%]">Attributs de l'article</h2>
                            <div class="grid grid-cols-2 gap-2">

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
                                <input type="checkbox" name="enVedette" id="enVedetteBtn" value="1"
                                    class="hidden" {{ $article->is_en_vedette == 1 ? 'checked' : '' }} />
                                <label for="enVedetteBtn"
                                    title="Ceci placera cette article dans votre section en vedette"
                                    class="col-span-2 cursor-pointer border-[1px] shadow border-gray-200 text-darkGrey font-bold py-2 text-center rounded-[0.375rem] transition duration-200 ease-in-out hover:bg-beige checked:bg-[#ebe3dc] checked:text-darkGrey">
                                    En vedette
                                </label>

                            </div>
                        </div>

                        <div class="grid col-span-1 gap-2">
                            <h2 class="text-[120%]">Quantité d'article mise en vente</h2>

                            <div class="grid grid-cols-2 grid-rows-2 gap-2">
                                <x-text-input id="quantiteArticle" class="col-span-2" type="number"
                                    name="quantiteArticle" placeholder="Quantité en vente" step="1"
                                    min="1" required value="{{ $article->quantite_disponible }}" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="idArtiste" value="{{ $artiste->id_artiste }}">
                    <input type="hidden" name="idArticle" value="{{ $artiste->id_article }}">

                    {{-- Boutons d'envoie --}}
                    <button type="submit" id="addArticleBtn" value="confirmer"
                        class="w-full mt-3 cursor-pointer bg-vert text-beige text-[36px] font-bold py-[10px] text-center rounded-md transition duration-200 ease-in-out hover:bg-[#00ba5c]">
                        Modifier article
                    </button>
                </form>

                {{-- Message de succès ou d'erreur en BD --}}
                @if (Session::all())
                    {{-- Succes de l'ajout d'un article --}}
                    @if (Session::has('succesArticle'))
                        <div class="col-span-2 h-fit mt-2" role="alert">
                            <div
                                class="bg-green-500 border-t border-[2px] border-green-900 text-white font-bold rounded-t px-4 py-2">
                                Succes</div>
                            <div class="rounded-b border-[2px] border-green-900 bg-green-100 px-4 py-2 text-green-700">
                                <p>{{ Session::get('succesArticle') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Erreur de l'ajout des mots clés --}}
                    @if (Session::has('erreurMotcles'))
                        <div class="col-span-2 h-fit mt-2" role="alert">
                            <div
                                class="bg-[#F44336] border-t border-[2px] border-[#B71C1C] text-white font-bold rounded-t px-4 py-2">
                                Erreur</div>
                            <div class="rounded-b border-[2px] border-[#B71C1C] bg-[#FFCDD2] px-4 py-2 text-[#D32F2F]">
                                <p>{{ Session::get('erreurMotcles') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Erreur de l'ajout des photo --}}
                    @if (Session::has('erreurPhotos'))
                        <div class="col-span-2 h-fit mt-2" role="alert">
                            <div
                                class="bg-[#F44336] border-t border-[2px] border-[#B71C1C] text-white font-bold rounded-t px-4 py-2">
                                Erreur</div>
                            <div class="rounded-b border-[2px] border-[#B71C1C] bg-[#FFCDD2] px-4 py-2 text-[#D32F2F]">
                                <p>{{ Session::get('succesPhotos') }}</p>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- Affichage des erreurs regroupées par section --}}
                @if ($errors->any())
                    <div class="col-span-2 p-3 mt-2 rounded-md bg-[#ffe5e9] border-[2px] border-rouge">
                        <ul class="list-disc ml-5">

                            {{-- Erreurs liées aux photos --}}
                            @if (
                                $errors->has('photo1') ||
                                    $errors->has('photo2') ||
                                    $errors->has('photo3') ||
                                    $errors->has('photo4') ||
                                    $errors->has('photo5'))
                                <li class="font-bold text-rouge">Photos de l'article</li>
                                <ul class="list-disc ml-5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($errors->has("photo{$i}"))
                                            <li class="text-rouge">{{ $errors->first("photo{$i}") }}</li>
                                        @endif
                                    @endfor
                                </ul>
                            @endif

                            {{-- Erreurs liées à l'identifiant de l'article --}}
                            @if (
                                $errors->has('nomArticle') ||
                                    $errors->has('prixArticle') ||
                                    $errors->has('quantiteArticle') ||
                                    $errors->has('descriptionArticle') ||
                                    $errors->has('motClesArticle'))
                                <li class="font-bold text-rouge">Identifiant de l'article</li>
                                <ul class="list-disc ml-5">
                                    @if ($errors->has('nomArticle'))
                                        <li class="text-rouge">{{ $errors->first('nomArticle') }}</li>
                                    @endif
                                    @if ($errors->has('prixArticle'))
                                        <li class="text-rouge">{{ $errors->first('prixArticle') }}</li>
                                    @endif
                                    @if ($errors->has('quantiteArticle'))
                                        <li class="text-rouge">{{ $errors->first('quantiteArticle') }}</li>
                                    @endif
                                    @if ($errors->has('descriptionArticle'))
                                        <li class="text-rouge">{{ $errors->first('descriptionArticle') }}</li>
                                    @endif
                                    @if ($errors->has('motClesArticle'))
                                        <li class="text-rouge">{{ $errors->first('motClesArticle') }}</li>
                                    @endif
                                </ul>
                            @endif

                            {{-- Erreurs liées aux dimensions et au poids --}}
                            @if (
                                $errors->has('hauteurArticle') ||
                                    $errors->has('largeurArticle') ||
                                    $errors->has('profondeurArticle') ||
                                    $errors->has('poidsArticle'))
                                <li class="font-bold text-rouge">Dimensions et poids de l'article</li>
                                <ul class="list-disc ml-5">
                                    @if ($errors->has('hauteurArticle'))
                                        <li class="text-rouge">{{ $errors->first('hauteurArticle') }}</li>
                                    @endif
                                    @if ($errors->has('largeurArticle'))
                                        <li class="text-rouge">{{ $errors->first('largeurArticle') }}</li>
                                    @endif
                                    @if ($errors->has('profondeurArticle'))
                                        <li class="text-rouge">{{ $errors->first('profondeurArticle') }}</li>
                                    @endif
                                    @if ($errors->has('poidsArticle'))
                                        <li class="text-rouge">{{ $errors->first('poidsArticle') }}</li>
                                    @endif
                                </ul>
                            @endif

                            {{-- Erreurs liées au type de pièce et usage alimentaire --}}
                            @if ($errors->has('typePiece') || $errors->has('pieceUnique'))
                                <li class="font-bold text-rouge">Type de pièce et usage alimentaire</li>
                                <ul class="list-disc ml-5">
                                    @if ($errors->has('typePiece'))
                                        <li class="text-rouge">{{ $errors->first('typePiece') }}</li>
                                    @endif
                                    @if ($errors->has('pieceUnique'))
                                        <li class="text-rouge">{{ $errors->first('pieceUnique') }}</li>
                                    @endif
                                </ul>
                            @endif

                        </ul>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
