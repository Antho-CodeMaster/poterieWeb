<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] flex flex-col w-4/5" x-data="{ openAvertir: false }">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="titre2-dark m-titreY p-sectionY border-b-2 border-darkGrey">Signalements</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof($signalements) }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col grow overflow-auto">
                @foreach ($signalements as $signalement)
                    <div x-data='{openArticleModal: false}'
                        class="px-4 my-2 w-full h-fit py-4 bg-lightGrey rounded-[14px] p-1 shrink-0 flex">

                        <div class="flex w-7/12">
                            <div class="w-1/2">
                                <h3 class="text-2xl text-darkGrey">
                                    {{ $signalement->article->nom }}</h3>
                                @if ($signalement->article->artiste->actif)
                                    <a class="hover:underline flex w-fit items-center"
                                        href="{{ route('kiosque', ['idUser' => $signalement->article->artiste->id_user]) }}"
                                        target="_blank">
                                        <img src="{{ asset($signalement->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                            alt="{{ $signalement->article->artiste->nom_artiste }}"
                                            class="rounded-full w-[48px] h-[48px]">
                                        <p>{{ $signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name }}
                                        </p>
                                    </a>
                                @else
                                    <div class="flex w-fit items-center">
                                        <img src="{{ asset($signalement->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                            alt="{{ $signalement->article->artiste->nom_artiste }}"
                                            class="rounded-full w-[48px] h-[48px]">
                                        <p>{{ $signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name }}
                                            <span class="text-red-500">(inactif)</span>
                                        </p>
                                    </div>
                                @endif
                                <p class="italic">Signalé par <span>{{ $signalement->user->name }}</span> le
                                    <span>{{ $signalement->date }}</span></p>
                            </div>
                            <div class="w-1/2 flex items-center justify-center">
                                <x-button.blue.leave
                                    @click=" $dispatch('open-article-modal');
                                $dispatch('set-article', {
                                    id_article: '{{ $signalement->article->id_article }}',
                                    id_artiste: '{{ $signalement->article->artiste->id_artiste }}',
                                    id_etat: '{{ $signalement->article->id_etat }}',
                                    nom: '{{ htmlspecialchars($signalement->article->nom) }}',
                                    description: '{{ htmlspecialchars($signalement->article->description) }}',
                                    prix: '{{ $signalement->article->prix }}',
                                    hauteur: '{{ $signalement->article->hauteur }}',
                                    largeur: '{{ $signalement->article->largeur }}',
                                    profondeur: '{{ $signalement->article->profondeur }}',
                                    poids: '{{ $signalement->article->poids }}',
                                    couleur: '{{ $signalement->article->couleur }}',
                                    quantite_disponible: '{{ htmlspecialchars($signalement->article->quantite_disponible) }}',
                                    is_unique: '{{ $signalement->article->is_unique }}',
                                    is_alimentaire: '{{ $signalement->article->is_alimentaire }}',
                                    is_sensible: '{{ $signalement->article->is_sensible }}',
                                });
                                 $dispatch('set-signalement', {
                                    client: '{{ htmlspecialchars($signalement->user->name) }}',
                                    raison: '{{ htmlspecialchars($signalement->description) }}'
                                });
                                 $dispatch('set-photos', '{{ $signalement->article->photo_article }}');
                                 $dispatch('set-mots-cles', '{{ $signalement->article->motCles }}'); ">Voir
                                    l'article et le signalement</x-button.blue.leave>
                            </div>
                        </div>
                        <div class="w-5/12 grid grid-cols-5 gap-x-6">
                            <div class="h-full col-span-2 flex items-center" x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
                                <x-button.yellow.exclamation class="w-full"
                                    @click="
                                $dispatch('open-avertir-modal');
                                $dispatch('set-id', {{ $signalement->article->artiste->id_user }});
                                $dispatch('set-name', {{ json_encode($signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name) }});
                                ">Avertir
                                    l'artiste</x-button.yellow.exclamation>
                            </div>
                            <form class="col-span-3 flex items-center"
                                action="{{ route('admin-signalements-delete') }}" method="POST">
                                @csrf
                                <input class="hidden" name="id" value={{ $signalement->id_signalement }}>
                                <input class="hidden" name="id_article" value={{ $signalement->article->id_article }}>
                                <x-button.red.trash class="w-full">Supprimer la publication</x-button.red.trash>
                            </form>
                            <div class="h-full col-span-2 flex items-center" x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
                                <x-button.yellow.exclamation class="w-full"
                                    @click="
                                $dispatch('open-avertir-modal');
                                $dispatch('set-id', {{ $signalement->id_user }});
                                $dispatch('set-name', {{ json_encode($signalement->user->name) }});
                                ">Avertir
                                    le client</x-button.yellow.exclamation>
                            </div>
                            <form class="col-span-3 flex items-center"
                                action="{{ route('admin-signalements-delete') }}" method="POST">
                                @csrf
                                <input class="hidden" name="id" value={{ $signalement->id_signalement }}>
                                <x-button.green.check class="w-full">Ignorer le signalement</x-button.green.check>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('admin.components.avertir-modal')
            @include('admin.components.article-modal')

            @if (Session::has('succes'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageSucces', [
                        'message' => Session::get('succes'),
                        'titre' => 'Succès',
                    ])
                </div>
            @endif
            @if (Session::has('erreur'))
                <div class="w-[500px] absolute right-2 bottom-10">
                    @include('messages.messageFail', [
                        'message' => Session::get('erreur'),
                        'titre' => 'Erreur',
                    ])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
