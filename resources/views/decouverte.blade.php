<x-app-layout>
    <div>
        @if (Session::all())
            {{-- Modal de remerciement d'avoir envoyé une demande --}}
            @if (Session::has('succesDemande'))
                @include('components.devenir-artiste-succes-modal')
            @endif
            {{-- Span qui, s'il existe, va trigger l'ouvertur du modal de connexion --}}
            @if (Session::has('openLoginModal'))
                <span id="showLoginModal" class="hidden"></span>
            @endif
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
    <div id="parallax-img" class="relative top-0 h-screen w-full overflow-hidden">
        <div class="bg-cover bg-center h-full w-full"
             style="background-image: url('/../covers/cover_picture.png');">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <h1 class="text-beige text-5xl font-bold">@Terracium</h1>
            </div>
        </div>
    </div>

    <div>
        @foreach($collections as $collection)
            <x-collection-articles :collection="$collection" />
        @endforeach
    </div>
</x-app-layout>
