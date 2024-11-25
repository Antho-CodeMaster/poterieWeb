<div x-data='{openArticleModal: false}'
    class="inline-block w-[300px] m-2 flex-shrink-0 overflow-hidden whitespace-nowrap bg-white shadow-md rounded-md cursor-pointer"
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
        created_at: '{{ $article->created_at }}',
        is_unique: '{{ $article->is_unique }}',
        is_alimentaire: '{{ $article->is_alimentaire }}',
        is_sensible: '{{ $article->is_sensible }}',
    });
    $dispatch('set-artiste', '{{ $article->artiste }}');
    $dispatch('set-photos', '{{ $article->photo_article }}');
    $dispatch('set-mots-cles', '{{ $article->motCles }}'); ">
    <img src="/../img/{{ $article->photosArticle->path }}" alt="{{ $article->nom }}"
        class="w-full h-48 object-cover rounded-t-md">
    <div class="p-4">
        <h3 class="text-lg font-bold text-nowrap overflow-hidden text-ellipsis">{{ $article->nom }}
        </h3>
        <p class="text-gray-600">{{ $article->prix }}$</p>
        <div class="flex items-center gap-2">
            <img src="{{ asset($article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                alt="{{ $article->artiste->nom_artiste }}" class="rounded-full w-[48px] h-[48px]">
            <form class="hover:underline" method="get" action="{{ route('admin-utilisateurs') }}">
                <input type="hidden" name="query"
                    value="{{ $article->artiste->nom_artiste ?? $article->artiste->user->name }}">

                <x-button.none.empty>{{ $article->artiste->nom_artiste ?? $article->artiste->user->name }}</x-button.none.empty>
            </form>
            <a class="hover:underline flex w-fit items-center"
                href="{{ route('kiosque', ['idUser' => $article->artiste->id_user]) }}" target="_blank">
                <x-button.border.kiosque></x-button.border.kiosque>
            </a>
        </div>
    </div>
</div>
