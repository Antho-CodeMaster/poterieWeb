<x-app-layout>

    {{-- Section Bannière --}}
    <section class="flex items-center justify-between p-[16px]" {{-- style="background-color: #{{ $artiste->couleur_banniere }}" --}}>

        {{-- Nom d'artiste --}}
        <div class="flex-1 text-left titre1-dark m-titreY">
            {{ $artiste->nom_artiste }}
        </div>

        {{-- Photo de profil --}}
        <div class="flex-shrink-0 mx-auto ">
            <img src="/../{{ $artiste->path_photo_profil }}" alt="photo de profil"
                class="w-[150px] h-[150px] rounded-[100px]">
        </div>

        {{-- Réseaux sociaux --}}
        <div class="flex-1 felx-shrink">
            @foreach ($reseaux as $reseau)
                <div class="text-right">
                    <a href="{{ $reseau->url }}{{ $reseau->pivot->username }}" class="inline-flex items-center">
                        <p class=" articleGrand-dark">{{ $reseau->pivot->username }}</p>

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'YouTube')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Instagram')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Facebook')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section En vedette --}}
    <section class="m-collection" x-data='{openArticleModal: false}'>
        <div class="flex justify-between items-end">
            <h2 class="titre2-dark mx-[16px] m-titreY select-none">En vedette</h2>
            {{-- Vérification si l'utilisateur qui visite la page est le propriétaire du kiosque --}}
            @if (Auth::id() == $artiste->id_user)
                {{-- Boutons d'artistes --}}
                <a href="{{ route('addArticleForm') }}" class=" m-titreY">
                    <svg width="75" height="75" viewBox="0 0 126 126" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="mx-[16px]">
                        <path
                            d="M45.8125 125.5L43.3125 105.5C41.9583 104.979 40.6823 104.354 39.4844 103.625C38.2865 102.896 37.1146 102.115 35.9687 101.281L17.375 109.094L0.1875 79.4062L16.2813 67.2188C16.1771 66.4896 16.125 65.7865 16.125 65.1094V60.8906C16.125 60.2135 16.1771 59.5104 16.2813 58.7812L0.1875 46.5938L17.375 16.9062L35.9687 24.7188C37.1146 23.8854 38.3125 23.1042 39.5625 22.375C40.8125 21.6458 42.0625 21.0208 43.3125 20.5L45.8125 0.5H80.1875L82.6875 20.5C84.0417 21.0208 85.3177 21.6458 86.5156 22.375C87.7135 23.1042 88.8854 23.8854 90.0312 24.7188L108.625 16.9062L125.813 46.5938L109.719 58.7812C109.823 59.5104 109.875 60.2135 109.875 60.8906V65.1094C109.875 65.7865 109.771 66.4896 109.562 67.2188L125.656 79.4062L108.469 109.094L90.0312 101.281C88.8854 102.115 87.6875 102.896 86.4375 103.625C85.1875 104.354 83.9375 104.979 82.6875 105.5L80.1875 125.5H45.8125ZM63.3125 84.875C69.3542 84.875 74.5104 82.7396 78.7812 78.4688C83.0521 74.1979 85.1875 69.0417 85.1875 63C85.1875 56.9583 83.0521 51.8021 78.7812 47.5313C74.5104 43.2604 69.3542 41.125 63.3125 41.125C57.1667 41.125 51.9844 43.2604 47.7656 47.5313C43.5469 51.8021 41.4375 56.9583 41.4375 63C41.4375 69.0417 43.5469 74.1979 47.7656 78.4688C51.9844 82.7396 57.1667 84.875 63.3125 84.875Z"
                            fill="#1D1B20" />
                    </svg>
                </a>
            @endif
        </div>

        @include('kiosque.carroussel')
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
            @foreach ($articles as $article)
                @if ($article->etat->etat == 'Visible client' || $article->etat->etat == 'Masqué client')
                    <div class="w-[170px] m-article whitespace-nowrap">

                        <div class="w-[160px] h-[160px] relative">
                            <div x-data="{ openArticleModal: false }">
                                @if ($article->id_etat == 2)
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                        console.log('Dispatching set-article');
                                        $dispatch('set-article', '{{ $article }}');
                                        $dispatch('set-photos', '{{ $article->photo_article }}');
                                        $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                @elseif ($article->quantite_disponible == 0 && $article->id_etat == 1)
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer brightness-[35%] h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                        console.log('Dispatching set-article');
                                        $dispatch('set-article', '{{ $article }}');
                                        $dispatch('set-photos', '{{ $article->photo_article }}');
                                        $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
                                @else
                                    <img src="/../img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                        class="select-none z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200"
                                        @click=" $dispatch('open-article-modal');
                                        console.log('Dispatching set-article');
                                        $dispatch('set-article', '{{ $article }}');
                                        $dispatch('set-photos', '{{ $article->photo_article }}');
                                        $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
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
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
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
                                <form action="{{ '/addArticleToPanier' }}" method="POST">
                                    @csrf
                                    <button type="submit" value="{{ $article->id_article }}" name="id_article"
                                        class="border-darkGrey border rounded-[24px] w-[100%] h-[30px] articlePetit-dark">Ajouter
                                        au
                                        panier</button>
                                </form>
                            @endif
                        @endif
                    </div>
                @endif
            @endforeach

        </div>

        {{-- Les modals --}}
        @include('kiosque.deleteArticle-modal')
        @include('kiosque.article-modal')
    </section>

    {{-- Message de Session --}}
    {{-- Succes de la suppression d'un article --}}
    @if (Session::has('succesDeleteArticle'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesDeleteArticle'),
                'titre' => 'Suppression',
            ])
        </div>
    @endif

    {{-- Succes d'un signalement d'article --}}
    @if (Session::has('succesSignalement'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesSignalement'),
                'titre' => 'Signalement',
            ])
        </div>
    @endif

    {{-- Échec d'un signalement d'article --}}
    @if (Session::has('echecSignalement'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('echecSignalement'),
                'titre' => 'Signalement',
            ])
        </div>
    @endif
</x-app-layout>

{{-- TODO: La partie responsive --}}
