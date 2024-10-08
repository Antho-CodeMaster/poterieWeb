<x-app-layout>
    <section class="grid lg:grid-cols-4">
        <header class="lg:col-span-4 gap-6 m-4">
            <h2 class="text-2xl font-medium text-gray-900">
                Résultat de la recherche "{{ $searchTerm }}"
            </h2>
            <p class="mt-1 text-lg text-gray-600">
                @if (sizeof($articles) == 0)
                    Aucun résultat disponible pour cette recherche.
                @elseif (sizeof($articles) == 1)
                    {{ sizeof($articles) }} résultat.
                @else
                    {{ sizeof($articles) }} résultats.
                @endif
            </p>
        </header>

        @foreach ($articles as $article)
            <div class="lg:col-span-1 gap-6 m-4">
                @include('recherche.partials.article-card', $article)
            </div>
        @endforeach
    </section>
</x-app-layout>
