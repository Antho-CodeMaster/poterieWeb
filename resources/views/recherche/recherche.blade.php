<x-app-layout>
    @include('kiosque.modal.article-modal')

    <section class="grid lg:grid-cols-4">
        <header class="lg:col-span-4 gap-6 m-4">
            <div class="w-full flex items-center gap-6 mb-4">
                <p class="titre2-dark lg:w-1/6">Rechercher: </p>
                <!-- Barre de recherche -->
                <div class="h-20 lg:w-5/6">
                    <form action="{{ route('recherche.getSearch') }}" method="GET" class="w-full h-full py-auto">
                        <input class="w-full rounded h-full titre2-dark" type="text"
                            placeholder="" name="query"
                            value="{{ $searchTerm }}">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
            <h2 class="text-2xl font-medium text-gray-900">
                Résultat de la recherche "{{ $searchTerm }}"
            </h2>
            <p class="mt-1 text-lg text-gray-600">
                @if (sizeof($articles) + sizeof($artistes) == 0)
                    Aucun résultat disponible pour cette recherche.
                @elseif (sizeof($articles) + sizeof($artistes) == 1)
                    {{ sizeof($articles) + sizeof($artistes) }} résultat.
                @else
                    {{ sizeof($articles) + sizeof($artistes) }} résultats.
                @endif
            </p>
        </header>
        @if (sizeof($articles) > 0)
            <h3 class="h-fit titre3-dark lg:col-span-4 gap-6 m-4">Articles</h3>
        @endif
        @foreach ($articles as $article)
            <div class="lg:col-span-1 gap-6 m-4">
                @include('recherche.partials.article-card', $article)
            </div>
        @endforeach
        @if (sizeof($artistes) > 0)
            <h3 class="h-fit titre3-dark lg:col-span-4 gap-6 m-4">Artistes</h3>
        @endif
        @foreach ($artistes as $artiste)
            <div class="lg:col-span-2 gap-6 m-4">
                @include('recherche.partials.artiste-card', $artiste)
            </div>
        @endforeach
    </section>
</x-app-layout>
