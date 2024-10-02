<!-- addArticle Modal -->
    {{-- Form pour ajouter un article --}}
    <form method="post" action="{{ route('addArticle') }}" id="addArticleForm" enctype="multipart/form-data"
        class="w-full rounded-r-[12px] rounded-b-[12px] bg-darkGrey p-4">
        @csrf

        {{-- Téléverser les photos --}}
        <div class="grid grid-cols-5 gap-6 mt-2">
            @for ($i = 1; $i <= 5; $i++)
                <div class="flex justify-center items-center">
                    <input type="file" name="photo{{ $i }}" id="photo{{ $i }}"
                        accept="image/png, image/jpg" class="hidden"
                        onchange="previewImage(event, {{ $i }})">

                    <!-- Conteneur pour l'aperçu de l'image ou le SVG -->
                    <div id="previewContainer{{ $i }}" class="flex items-center">
                        <!-- Par défaut, le bouton SVG pour déclencher l'upload -->
                        <button type="button" onclick="document.getElementById('photo{{ $i }}').click()"
                            class="flex items-center">
                            <svg id="svg{{ $i }}" class="w-full h-[150px]" viewBox="0 0 293 276"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2.5" y="3.33682" width="288" height="269.43" rx="13.5" stroke="#f4f0ec"
                                    stroke-width="5" />
                                <g clip-path="url(#clip0_4003_30)">
                                    <path
                                        d="M116.667 94.6428C112.477 94.6428 109.083 98.0921 109.083 102.351V164.013C109.083 168.271 112.477 171.72 116.667 171.72H142.009C140.886 169.323 140.103 166.737 139.72 164.013H120.458C118.365 164.013 116.667 162.286 116.667 160.159V150.193C116.667 149.172 117.065 148.189 117.778 147.468L121.569 143.614C123.052 142.107 125.452 142.107 126.931 143.614L139.417 156.305L139.772 155.944C141.767 143.052 152.714 133.182 165.958 133.182C167.248 133.182 168.51 133.309 169.75 133.49V120.958C169.75 118.915 168.95 116.953 167.528 115.508L149.222 96.901C147.8 95.4558 145.87 94.6428 143.86 94.6428H116.667ZM143.208 100.251L164.063 121.62H147C144.907 121.62 143.208 119.893 143.208 117.766V100.251ZM139.417 129.328C141.51 129.328 143.208 131.054 143.208 133.182C143.208 135.309 141.51 137.036 139.417 137.036C137.324 137.036 135.625 135.309 135.625 133.182C135.625 131.054 137.324 129.328 139.417 129.328ZM165.958 140.889C155.49 140.889 147 149.518 147 160.159C147 170.799 155.49 179.428 165.958 179.428C176.427 179.428 184.917 170.799 184.917 160.159C184.917 149.518 176.427 140.889 165.958 140.889ZM165.958 148.597C168.051 148.597 169.75 150.324 169.75 152.451V156.305H173.542C175.635 156.305 177.333 158.031 177.333 160.159C177.333 162.286 175.635 164.013 173.542 164.013H169.75V167.867C169.75 169.994 168.051 171.72 165.958 171.72C163.865 171.72 162.167 169.994 162.167 167.867V164.013H158.375C156.282 164.013 154.583 162.286 154.583 160.159C154.583 158.031 156.282 156.305 158.375 156.305H162.167V152.451C162.167 150.324 163.865 148.597 165.958 148.597Z"
                                        fill="#f4f0ec" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                @if ($errors->has("photo{$i}"))
                    <span class="text-red-500">{{ $errors->first("photo{$i}") }}</span>
                @endif
            @endfor
        </div>

        <div class="grid grid-cols-4 gap-6 mt-4">
            <!-- Nom Article -->
            <x-text-input id="nomArticle" class="w-full col-span-2" type="text" name="nomArticle" required
                placeholder="Nom de l'article" />
            @if ($errors->has('nomArticle'))
                <span class="text-red-500">{{ $errors->first('nomArticle') }}</span>
            @endif

            <!-- Prix Article -->
            <x-text-input id="prixArticle" class="w-full col-span-1" type="number" name="prixArticle" required
                step="0.01" min="0" placeholder="Prix ($)" />
            @if ($errors->has('prixArticle'))
                <span class="text-red-500">{{ $errors->first('prixArticle') }}</span>
            @endif

            <!-- Type de pièce -->
            <select id="pieceUnique" name="pieceUnique"
                class="w-full col-span-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                required>
                <option value="" disabled selected hidden>Sélectionner un type d'article</option>
                <option value="1">Unique</option>
                <option value="0">En série</option>
            </select>
            @if ($errors->has('pieceUnique'))
                <span class="text-red-500">{{ $errors->first('pieceUnique') }}</span>
            @endif
        </div>

        <div class="grid grid-cols-4 gap-6 mt-4">
            <!-- Description de l'article -->
            <textarea id="descriptionArticle" name="descriptionArticle" rows="2"
                class="w-full col-span-4 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="Description" required></textarea>
            @if ($errors->has('descriptionArticle'))
                <span class="text-red-500">{{ $errors->first('descriptionArticle') }}</span>
            @endif
        </div>

        <div class="grid grid-cols-4 gap-6 mt-4">
            <!-- Hauteur et Largeur de l'article -->
            <x-text-input id="hauteurArticle" class="w-full col-span-1" type="number" name="hauteurArticle"
                placeholder="Hauteur (cm)" min="0" required />
            @if ($errors->has('hauteurArticle'))
                <span class="text-red-500">{{ $errors->first('hauteurArticle') }}</span>
            @endif

            <x-text-input id="largeurArticle" class="w-full col-span-1" type="number" name="largeurArticle"
                placeholder="Largeur (cm)" min="0" required />
            @if ($errors->has('largeurArticle'))
                <span class="text-red-500">{{ $errors->first('largeurArticle') }}</span>
            @endif

            <!-- Type de pièce -->
            <select id="typePiece" name="typePiece" required
                class="w-full col-span-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="" disabled selected hidden>Sélectionner un type de pièce</option>
                <option value="1">Alimentaire</option>
                <option value="0">Non-alimentaire</option>
            </select>
            @if ($errors->has('typePiece'))
                <span class="text-red-500">{{ $errors->first('typePiece') }}</span>
            @endif
        </div>

        <div class="grid grid-cols-4 gap-6 mt-4">
            <!-- Profondeur, Poids et Quantité de l'article -->
            <x-text-input id="profondeurArticle" class="w-full col-span-1" type="number" name="profondeurArticle"
                placeholder="Profondeur (cm)" min="0" required />
            @if ($errors->has('profondeurArticle'))
                <span class="text-red-500">{{ $errors->first('profondeurArticle') }}</span>
            @endif

            <x-text-input id="poidsArticle" class="w-full col-span-1" type="number" name="poidsArticle"
                placeholder="Poids (g)" min="0" required />
            @if ($errors->has('poidsArticle'))
                <span class="text-red-500">{{ $errors->first('poidsArticle') }}</span>
            @endif

            <x-text-input id="quantiteArticle" class="w-full col-span-2" type="number" name="quantiteArticle"
                placeholder="Quantité en vente" step="1" min="1" required />
            @if ($errors->has('quantiteArticle'))
                <span class="text-red-500">{{ $errors->first('quantiteArticle') }}</span>
            @endif
        </div>

        <div class="grid grid-cols-4 gap-6 mt-4">
            <!-- Mots-clés -->
            <textarea id="motClesArticle" name="motClesArticle" rows="2"
                class="w-full col-span-4 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="#Funky#MeilleurArticleEver#Automne#Aussiété"></textarea>
            @if ($errors->has('motClesArticle'))
                <span class="text-red-500">{{ $errors->first('motClesArticle') }}</span>
            @endif
        </div>

        {{-- Les boutons (en vedette, flouter et masquer) --}}
        <div class="grid grid-cols-4 gap-6 mt-4">

            {{-- masquer --}}
            <input type="hidden" name="masquer" value="1" />
            <input type="checkbox" name="masquer" id="masquerBtn" value="2" class="hidden" />
            <label for="masquerBtn"
                class="col-span-1 w-full cursor-pointer bg-[#fff] text-darkGrey font-bold py-2 text-center rounded-md transition duration-200 ease-in-out hover:bg-gray-500">
                Masquer
            </label>

            {{-- floutter --}}
            <input type="hidden" name="flouter" value="0" />
            <input type="checkbox" name="flouter" id="flouterBtn" value="1" class="hidden" />
            <label for="flouterBtn"
                class="col-span-1 w-full cursor-pointer bg-[#fff] text-darkGrey font-bold py-2 text-center rounded-md transition duration-200 ease-in-out hover:bg-gray-500">
                Flouter
            </label>

            {{-- En vedette --}}
            <input type="hidden" name="enVedette" value="0" />
            <input type="checkbox" name="enVedette" id="enVedetteBtn" value="1" class="hidden" />
            <label for="enVedetteBtn"
                class="col-span-2 w-full cursor-pointer bg-[#fff] text-darkGrey font-bold py-2 text-center rounded-md transition duration-200 ease-in-out hover:bg-gray-500">
                En vedette
            </label>
        </div>

        <input type="hidden" name="idArtiste" value="{{ $artiste->id_artiste }}">

        {{-- Boutons d'envoie --}}
        <button type="submit" id="addArticleBtn" value="confirmer"
            class="w-full mt-4 cursor-pointer bg-vert text-beige text-[36px] font-bold py-[10px] text-center rounded-md hover:bg-[#00ba5c]">
            Ajouter article
        </button>
    </form>

