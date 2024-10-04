<x-app-layout>
    <div>
        @foreach ($articles as $article)
            @if ($article->etat->etat == 'Visible client')
                @include('recherche.partials.article-card', $article)
            @endif
        @endforeach
    </div>
    </x-app-layout>
