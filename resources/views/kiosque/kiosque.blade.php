<x-app-layout>
    {{-- Modal de remerciement d'avoir envoyé une demande --}}
    @if (Session::has('firstaccess'))
        @include('components.kiosque-first-access-modal')
    @endif

    {{-- Section Bannière --}}
    <section class="flex items-center justify-between p-[16px] bg-{{ $artiste->couleur_banniere }}">


        <div class="dynamicText flex-1" data-background-color="{{ $artiste->couleur_banniere }}">
            {{-- Nom d'artiste --}}
            <div class="text-left titre1-dark m-titreY">
                @if ($artiste->nom_artiste == null)
                    {{ $artiste->user->name }}
                @else
                    {{ $artiste->nom_artiste }}
                @endif
            </div>

            {{-- Déscription de l'artiste --}}
            <div class=" text-left textGrand-dark">
                {{ $artiste->description }}
            </div>
        </div>

        {{-- Photo de profil --}}
        <div class="flex-shrink-0 mx-auto ">
            <img src="/../{{ $artiste->path_photo_profil }}" alt="photo de profil"
                class="w-[150px] h-[150px] rounded-[100px]">
        </div>

        {{-- Réseaux sociaux --}}
        <div class="dynamicText flex-1 felx-shrink">
            @foreach ($reseaux as $reseau)
                <div class="text-right">
                    <a href="{{ $reseau->url }}{{ $reseau->pivot->username }}" class="inline-flex items-center">
                        <p class="articleGrand-dark">{{ $reseau->pivot->username }}</p>

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'YouTube')
                            <svg class="w-10 h-10 dynamicText" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                    clip-rule="evenodd" class="dynamicText"/>
                            </svg>
                        @endif

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Instagram')
                            <svg class="w-10 h-10 dynamicText" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                    clip-rule="evenodd" class="dynamicText" />
                            </svg>
                        @endif

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Facebook')
                            <svg class="w-10 h-10 dynamicText" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                    clip-rule="evenodd" class="dynamicText" />
                            </svg>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section En vedette --}}
    <section class="m-collection" x-data='{openArticleModal: false}'>

        {{-- Vérifie si il y a des articles en vedette et affiche cette collection en fonction de cela --}}
        @if ($enVedette == true)
            <h2 class="titre2-dark mx-[16px] m-titreY select-none">En vedette</h2>
            @include('kiosque.carroussel')
        @else
            @if (Auth::id() == $artiste->id_user)
                <h2 class="titre2-dark mx-[16px] m-titreY select-none">En vedette</h2>
                <div class="bg-beige p-sectionY">
                    <p class=" textGrand-dark mx-[16px] select-none font-bold">Pour le moment vous n'avez aucun article
                        en vedette.
                    </p>
                    @if ($hasArticle == false)
                        <a href="{{ route('tousMesArticles') }}" class=" textMoyen-dark underline mx-[16px]">Voici un
                            lien pour modifier un article afin de le rajouter dans la collection en vedette</a>
                    @else
                        <a href="{{ route('addArticleForm', ['idArticle' => 1]) }}"
                            class=" textMoyen-dark underline mx-[16px]">Voici un lien pour
                            ajouter un nouvelle article et le placer en vedette</a>
                    @endif
                </div>
            @endif
        @endif

    </section>

    {{-- Section Tous les articles --}}
    <section class="m-collection" x-data='{openDeleteArticle: false}' x-data='{openArticleModal: false}'>
        <div class="flex justify-between items-end">
            <div class="flex items-center">
                <h2 class=" titre2-dark mx-[16px] mr-[2px] m-titreY select-none">Tous les articles</h2>

                {{-- Bouton de filtre --}}
                <svg class="w-8 h-8 cursor-pointer select-none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                    <path
                        d="M10.83 5a3.001 3.001 0 0 0-5.66 0H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17ZM4 11h9.17a3.001 3.001 0 0 1 5.66 0H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2Zm1.17 6H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17a3.001 3.001 0 0 0-5.66 0Z" />
                </svg>
            </div>


        </div>

        <div class="bg-beige flex flex-wrap justify-between">

            {{-- Affichage de tous les articles --}}
            @if ($hasArticle == false)
                @if (Auth::id() == $artiste->id_user)
                    <div class="bg-beige p-sectionY">
                        <p class=" textGrand-dark mx-[16px] select-none font-bold">Pour le moment vous n'avez aucun
                            article en vente
                        </p>
                        <a href="{{ route('addArticleForm', ['idArticle' => 1]) }}"
                            class=" textMoyen-dark underline mx-[16px]">Voici un lien pour
                            mettre en vente un article </a>
                    </div>
                @else
                    <p>Aucun article pour le moment</p>
                @endif
            @else
                @foreach ($articles as $article)
                    @if ($article->etat->etat == 'Visible client' || $article->etat->etat == 'Masqué client')
                        <div class="w-[170px] m-article whitespace-nowrap">

                            {{-- L'image de l'Article --}}
                            <div class="w-[160px] h-[160px] relative">
                                <div x-data="{ openArticleModal: false }" class="overflow-hidden rounded-[16px]">
                                    @if (Auth::check())
                                        @if (Auth::user()->contenu_sensible == 1)
                                            @if ($article->id_etat == 2)
                                                <img src="/../img/{{ $article->photosArticle->path }}"
                                                    alt="Photo d'article"
                                                    class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                    @click=" $dispatch('open-article-modal');
                                                    $dispatch('set-article', {
                                                        id_article: '{{ $article->id_article }}',
                                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                                        id_etat: '{{ $article->id_etat }}',
                                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                                        description: '{{ htmlspecialchars($article->description) }}',
                                                        prix: '{{ $article->prix }}',
                                                        hauteur: '{{ $article->hauteur }}',
                                                        largeur: '{{ $article->largeur }}',
                                                        profondeur: '{{ $article->profondeur }}',
                                                        poids: '{{ $article->poids }}',
                                                        couleur: '{{ $article->couleur }}',
                                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                        is_unique: '{{ $article->is_unique }}',
                                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                                        is_sensible: '{{ $article->is_sensible }}',
                                                    });
                                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                            @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                                <img src="/../img/{{ $article->photosArticle->path }}"
                                                    alt="Photo d'article"
                                                    class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                    @click=" $dispatch('open-article-modal');
                                                    $dispatch('set-article', {
                                                        id_article: '{{ $article->id_article }}',
                                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                                        id_etat: '{{ $article->id_etat }}',
                                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                                        description: '{{ htmlspecialchars($article->description) }}',
                                                        prix: '{{ $article->prix }}',
                                                        hauteur: '{{ $article->hauteur }}',
                                                        largeur: '{{ $article->largeur }}',
                                                        profondeur: '{{ $article->profondeur }}',
                                                        poids: '{{ $article->poids }}',
                                                        couleur: '{{ $article->couleur }}',
                                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                        is_unique: '{{ $article->is_unique }}',
                                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                                        is_sensible: '{{ $article->is_sensible }}',
                                                    });
                                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                            @else
                                                <img src="/../img/{{ $article->photosArticle->path }}"
                                                    alt="Photo d'article"
                                                    class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                    @click=" $dispatch('open-article-modal');
                                                    $dispatch('set-article', {
                                                        id_article: '{{ $article->id_article }}',
                                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                                        id_etat: '{{ $article->id_etat }}',
                                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                                        description: '{{ htmlspecialchars($article->description) }}',
                                                        prix: '{{ $article->prix }}',
                                                        hauteur: '{{ $article->hauteur }}',
                                                        largeur: '{{ $article->largeur }}',
                                                        profondeur: '{{ $article->profondeur }}',
                                                        poids: '{{ $article->poids }}',
                                                        couleur: '{{ $article->couleur }}',
                                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                        is_unique: '{{ $article->is_unique }}',
                                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                                        is_sensible: '{{ $article->is_sensible }}',
                                                    });
                                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                            @endif
                                        @else
                                            @if ($article->id_etat == 2)
                                                <img src="/../img/{{ $article->photosArticle->path }}"
                                                    alt="Photo d'article"
                                                    class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200 {{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }}"
                                                    @click=" $dispatch('open-article-modal');
                                                    $dispatch('set-article', {
                                                        id_article: '{{ $article->id_article }}',
                                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                                        id_etat: '{{ $article->id_etat }}',
                                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                                        description: '{{ htmlspecialchars($article->description) }}',
                                                        prix: '{{ $article->prix }}',
                                                        hauteur: '{{ $article->hauteur }}',
                                                        largeur: '{{ $article->largeur }}',
                                                        profondeur: '{{ $article->profondeur }}',
                                                        poids: '{{ $article->poids }}',
                                                        couleur: '{{ $article->couleur }}',
                                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                        is_unique: '{{ $article->is_unique }}',
                                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                                        is_sensible: '{{ $article->is_sensible }}',
                                                    });
                                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                            @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                                <img src="/../img/{{ $article->photosArticle->path }}"
                                                    alt="Photo d'article"
                                                    class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                    @click=" $dispatch('open-article-modal');
                                                    $dispatch('set-article', {
                                                        id_article: '{{ $article->id_article }}',
                                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                                        id_etat: '{{ $article->id_etat }}',
                                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                                        description: '{{ htmlspecialchars($article->description) }}',
                                                        prix: '{{ $article->prix }}',
                                                        hauteur: '{{ $article->hauteur }}',
                                                        largeur: '{{ $article->largeur }}',
                                                        profondeur: '{{ $article->profondeur }}',
                                                        poids: '{{ $article->poids }}',
                                                        couleur: '{{ $article->couleur }}',
                                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                        is_unique: '{{ $article->is_unique }}',
                                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                                        is_sensible: '{{ $article->is_sensible }}',
                                                    });
                                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                            @else
                                                <img src="/../img/{{ $article->photosArticle->path }}"
                                                    alt="Photo d'article"
                                                    class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                    @click=" $dispatch('open-article-modal');
                                                    $dispatch('set-article', {
                                                        id_article: '{{ $article->id_article }}',
                                                        id_artiste: '{{ $article->artiste->id_artiste }}',
                                                        id_etat: '{{ $article->id_etat }}',
                                                        nom: '{{ htmlspecialchars($article->nom) }}',
                                                        description: '{{ htmlspecialchars($article->description) }}',
                                                        prix: '{{ $article->prix }}',
                                                        hauteur: '{{ $article->hauteur }}',
                                                        largeur: '{{ $article->largeur }}',
                                                        profondeur: '{{ $article->profondeur }}',
                                                        poids: '{{ $article->poids }}',
                                                        couleur: '{{ $article->couleur }}',
                                                        quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                        is_unique: '{{ $article->is_unique }}',
                                                        is_alimentaire: '{{ $article->is_alimentaire }}',
                                                        is_sensible: '{{ $article->is_sensible }}',
                                                    });
                                                    $dispatch('set-artiste', '{{ $article->artiste }}');
                                                    $dispatch('set-photos', '{{ $article->photo_article }}');
                                                    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                            @endif
                                        @endif
                                    @else
                                        @if ($article->id_etat == 2)
                                            <img src="/../img/{{ $article->photosArticle->path }}"
                                                alt="Photo d'article"
                                                class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200 {{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }}"
                                                @click=" $dispatch('open-article-modal');
                                                $dispatch('set-article', {
                                                    id_article: '{{ $article->id_article }}',
                                                    id_artiste: '{{ $article->artiste->id_artiste }}',
                                                    id_etat: '{{ $article->id_etat }}',
                                                    nom: '{{ htmlspecialchars($article->nom) }}',
                                                    description: '{{ htmlspecialchars($article->description) }}',
                                                    prix: '{{ $article->prix }}',
                                                    hauteur: '{{ $article->hauteur }}',
                                                    largeur: '{{ $article->largeur }}',
                                                    profondeur: '{{ $article->profondeur }}',
                                                    poids: '{{ $article->poids }}',
                                                    couleur: '{{ $article->couleur }}',
                                                    quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                    is_unique: '{{ $article->is_unique }}',
                                                    is_alimentaire: '{{ $article->is_alimentaire }}',
                                                    is_sensible: '{{ $article->is_sensible }}',
                                                });
                                                $dispatch('set-artiste', '{{ $article->artiste }}');
                                                $dispatch('set-photos', '{{ $article->photo_article }}');
                                                $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                        @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                            <img src="/../img/{{ $article->photosArticle->path }}"
                                                alt="Photo d'article"
                                                class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                @click=" $dispatch('open-article-modal');
                                                $dispatch('set-article', {
                                                    id_article: '{{ $article->id_article }}',
                                                    id_artiste: '{{ $article->artiste->id_artiste }}',
                                                    id_etat: '{{ $article->id_etat }}',
                                                    nom: '{{ htmlspecialchars($article->nom) }}',
                                                    description: '{{ htmlspecialchars($article->description) }}',
                                                    prix: '{{ $article->prix }}',
                                                    hauteur: '{{ $article->hauteur }}',
                                                    largeur: '{{ $article->largeur }}',
                                                    profondeur: '{{ $article->profondeur }}',
                                                    poids: '{{ $article->poids }}',
                                                    couleur: '{{ $article->couleur }}',
                                                    quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                    is_unique: '{{ $article->is_unique }}',
                                                    is_alimentaire: '{{ $article->is_alimentaire }}',
                                                    is_sensible: '{{ $article->is_sensible }}',
                                                });
                                                $dispatch('set-artiste', '{{ $article->artiste }}');
                                                $dispatch('set-photos', '{{ $article->photo_article }}');
                                                $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                        @else
                                            <img src="/../img/{{ $article->photosArticle->path }}"
                                                alt="Photo d'article"
                                                class="{{ $article->is_sensible == 1 ? ' blur-[18px]' : '' }} select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                                @click=" $dispatch('open-article-modal');
                                                $dispatch('set-article', {
                                                    id_article: '{{ $article->id_article }}',
                                                    id_artiste: '{{ $article->artiste->id_artiste }}',
                                                    id_etat: '{{ $article->id_etat }}',
                                                    nom: '{{ htmlspecialchars($article->nom) }}',
                                                    description: '{{ htmlspecialchars($article->description) }}',
                                                    prix: '{{ $article->prix }}',
                                                    hauteur: '{{ $article->hauteur }}',
                                                    largeur: '{{ $article->largeur }}',
                                                    profondeur: '{{ $article->profondeur }}',
                                                    poids: '{{ $article->poids }}',
                                                    couleur: '{{ $article->couleur }}',
                                                    quantite_disponible: '{{ htmlspecialchars($article->quantite_disponible) }}',
                                                    is_unique: '{{ $article->is_unique }}',
                                                    is_alimentaire: '{{ $article->is_alimentaire }}',
                                                    is_sensible: '{{ $article->is_sensible }}',
                                                });
                                                $dispatch('set-artiste', '{{ $article->artiste }}');
                                                $dispatch('set-photos', '{{ $article->photo_article }}');
                                                $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                        @endif
                                    @endif
                                </div>

                                {{-- Changer l'image selon l'état de l'article --}}
                                @if (Auth::id() == $artiste->id_user)
                                    <!-- Trigger Button for DeleteArticle Modal -->
                                    <div class="w-fit" x-data="{ openDeleteArticle: false }">
                                        <button
                                            @click=" $dispatch('open-delete-article-modal');
                                                 $dispatch('set-id', {{ $article->id_article }});">
                                            <svg class="w-9 h-9 text-blue-900 hover:text-red-600  absolute top-0 right-0"
                                                width="40" height="44" viewBox="0 0 40 44" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2 10H6M6 10H38M6 10V38C6 39.0609 6.42143 40.0783 7.17157 40.8284C7.92172 41.5786 8.93913 42 10 42H30C31.0609 42 32.0783 41.5786 32.8284 40.8284C33.5786 40.0783 34 39.0609 34 38V10M12 10V6C12 4.93913 12.4214 3.92172 13.1716 3.17157C13.9217 2.42143 14.9391 2 16 2H24C25.0609 2 26.0783 2.42143 26.8284 3.17157C27.5786 3.92172 28 4.93913 28 6V10M16 20V32M24 20V32"
                                                    stroke="#FC6262" stroke-width="4" stroke-linecap="round"
                                                    stroke-linejoin="round" class="" />
                                            </svg>
                                        </button>
                                    </div>
                                    @include('kiosque.deleteArticle-modal')


                                    <form
                                        action="{{ route('modifArticleForm', ['idArticle' => $article->id_article]) }}"
                                        class="absolute top-0 left-0 z-[99]" method="get">
                                        @csrf
                                        <button type="submit">
                                            <svg class="w-12 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="#ffffff" viewBox="0 0 24 24" stroke="#444444">
                                                <path fill-rule="evenodd"
                                                    d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="flex justify-between items-center my-[4px]">
                                <div class="w-[75%]">
                                    <p class=" articlePetit-dark">{{ $article->nom }}</p>
                                    <p class="textPetit-dark">{{ $article->prix }}$
                                    </p>
                                </div>

                                {{-- Vérifie chaque like du user avec l'article --}}
                                @if ($article->isLikedByUser(Auth::id()))
                                    <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="#ff0000" viewBox="0 0 24 24">
                                        <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
                                    </svg>
                                @else
                                    <svg class="w-10 h-10 text-gray-800 dark:text-white mb-[2px]" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="#444444" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                    </svg>
                                @endif
                            </div>

                            {{-- Changer le bouton selon l'état de l'article --}}
                            @if ($article->id_etat == 2)
                                <p
                                    class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-light bg-darkGrey text-center">
                                    Masqué</p>
                            @elseif ($article->id_etat == 1)
                                @if ($article->quantite_disponible == 0)
                                    <p
                                        class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-light bg-darkGrey text-center">
                                        En rupture de stock</p>
                                @elseif ($article->quantite_disponible > 0)
                                    {{-- Si l'artiste est sur son propre kiosque l'empecher d'acheter --}}
                                    @if ($article->artiste->id_user != Auth::id())
                                        <form action="{{ '/addArticleToPanier' }}" method="POST">
                                            @csrf
                                            <button type="submit" value="{{ $article->id_article }}"
                                                name="id_article"
                                                class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-dark">Ajouter
                                                au
                                                panier</button>
                                        </form>
                                    @else
                                        <button type="button" value="{{ $article->id_article }}" name="id_article"
                                            class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-dark cursor-default">Visible</button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- Les modals --}}
        @include('kiosque.article-modal')
    </section>

    {{-- Message de Session --}}
    {{-- Succes de la suppression d'un article --}}
    @if (Session::has('succesDeleteArticle'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesDeleteArticle'),
                'titre' => 'Suppression',
            ])
        </div>
    @endif

    {{-- Succes d'un signalement d'article --}}
    @if (Session::has('succesSignalement'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesSignalement'),
                'titre' => 'Signalement',
            ])
        </div>
    @endif

    {{-- Échec d'un signalement d'article --}}
    @if (Session::has('echecSignalement'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('echecSignalement'),
                'titre' => 'Signalement',
            ])
        </div>
    @endif

    {{-- Artiste inactif --}}
    @if (Session::has('errorInactif'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('errorInactif'),
                'titre' => 'Artiste pas trouvée',
            ])
        </div>
    @endif

</x-app-layout>


{{-- TODO: La partie responsive --}}


{{-- Fonction pour changer la couleur du texte en fonction du background --}}
{{-- Applique le style en fonction de la couleur de bannière --}}
<style>
    .dynamicText {
        color: white;
        /* Couleur du texte (et du SVG via currentColor) */
        filter: brightness(2);
        /* Applique un éclaircissement du texte et du SVG */
        mix-blend-mode: luminosity;
        /* Change la couleur du texte et du SVG selon la luminosité du fond */
    }

</style>
