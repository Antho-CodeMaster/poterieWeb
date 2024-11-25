<x-app-layout>
    <div>
        {{-- Modal de remerciement d'avoir envoyé une demande --}}
        @if (Session::has('succesDemande'))
            @include('components.devenir-artiste-succes-modal')
        @endif
        {{-- Modal de remerciement d'avoir envoyé une demande --}}
        @if (Session::has('succesRenouvellement'))
            <div class="w-[500px] fixed z-50 right-2 bottom-10">
                @include('messages.messageSucces', [
                    'message' => Session::get('succesRenouvellement'),
                    'titre' => 'Succès',
                ])
            </div>
        @endif
        {{-- Span qui, s'il existe, va trigger l'ouvertur du modal de connexion --}}
        @if (Session::has('openLoginModal'))
            <span id="showLoginModal" class="hidden"></span>
        @endif
        @if ($errors->any())
        <div class="w-[500px] fixed z-50 right-2 bottom-10">
            @include('messages.messageFail', [
                'message' => $errors->first('msg'),
                'titre' => 'Échec',
            ])
        </div>
        @endif
    </div>

    <!--
    <div class="bg-beigeFoncé m-section">
        <h1 class="titreH1-dark">Terracium H1</h1>
        <h2 class="titreH2-dark">Terracium H2</h2>
        <p class="textGrand-dark">Terracium textNormal Gros</p>
        <p class="titreSection-dark">Terracium titreSection</p>
        <p class="articleGrand-dark">Terracium titreArticleGros</p>
        <p class="articlePetit-dark">Terracium titreArticlePetit</p>
        <p class="textFooter-dark">Terracium footer</p>
        <p class="textNavigation-dark">Terracium navigation</p>

        <div class="bg-darkGrey">
            <h1 class="titreH1-light">Terracium H1</h1>
            <h2 class="titreH2-light">Terracium H2</h2>
            <p class="textPetit-light">Terracium textNormal petit</p>
            <p class="titreSection-light">Terracium titreSection</p>
            <p class="articleGrand-light">Terracium titreArticleGros</p>
            <p class="articlePetit-light">Terracium titreArticlePetit</p>
            <p class="textFooter-light">Terracium footer</p>
            <p class="textNavigation-light">Terracium navigation</p>
        </div>
    </div>
    -->

    <!-- Parallax Section -->
    <div id="parallax-img" class="relative top-0 h-[101vh] w-full overflow-hidden">
        <div class="bg-cover bg-center min-h-full w-full" style="background-image: url('/../covers/cover_picture.png');">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-between items-center">
                <!-- Centered title -->
                <h1 class="text-beige text-8xl font-bold mt-auto">@Terracium</h1>

                <div class="my-8 text-2xl text-center">
                    <ul class="flex justify-center space-x-4">
                        @foreach ($collections as $collection => $articles)
                            @if (!$articles->isEmpty())
                                <li class="relative inline-block overflow-hidden">
                                    <a href="#{{ $collection }}"
                                    class="p-4 text-beige hover:text-vert hover9 overflow-hidden relative inline-block transition-all duration-200 ease-out"
                                    data-hover-label="{{ $collection }}">
                                        <span class="hover9__label inline-block transition-transform duration-300 ease-[cubic-bezier(0.86, 0.6, 0.08, 1.01)]">
                                            {{ $collection }}
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <!-- Bottom-centered anchor link -->
                <a href="#collections" class="mb-[20%]">
                    <div class="arrow group">
                        <span class="group-hover:border-vert group-hover:ease-in-out group-hover:duration-300"></span>
                        <span class="group-hover:border-vert group-hover:ease-in-out group-hover:duration-300"></span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Les modals --}}
    @include('kiosque.modal.article-modal')

    <div id="collections">
        @foreach ($collections as $collection => $articles)
            @if (!$articles->isEmpty())
                <div id="{{ $collection }}" class="pt-2">
                    <x-decouverte.collection-articles :collection="$articles" :collectionName="$collection" />
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
