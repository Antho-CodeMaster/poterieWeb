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

    <div>
        @foreach($collections as $collection)
            <div>
                <h2 class="titre">{{ $collection->collection }}</h2>
                <div class="flex w-[500px]">
                    @foreach($collection->articles as $article)
                        @include('recherche.partials.article-card', $article)
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
