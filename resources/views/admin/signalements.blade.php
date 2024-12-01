<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] flex flex-col w-full" x-data="{ openAvertir: false, openDelete: false }">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <div class="flex items-center border-b-2 border-darkGrey gap-5 justify-between">
                    <h1 class="titre2-dark m-titreY p-sectionY">Signalements</h1>
                    <div class="flex gap-2">
                        <div class="flex items-center gap-2">
                            <?php
                            switch ($page) {
                                case 0:
                                case 1:
                                    $initial = 1;
                                    $final = 4;
                                    break;
                                case $total_pages - 2:
                                    $initial = $page - 2;
                                    $final = $page + 1;
                                    break;
                                case $total_pages - 1:
                                    $initial = $page - 3;
                                    $final = $page + 1;
                                    break;
                                default:
                                    $initial = $page - 1;
                                    $final = $page + 2;
                                    break;
                            }
                            ?>
                            <p>Page: </p>
                            @for ($i = $initial; $i <= $final && $i < $total_pages; $i++)
                                <a class="px-4 py-2 rounded
                        {{ $page + 1 == $i ? 'bg-darkGrey text-white' : '' }}"
                                    href="{{ route('admin-signalements') . '?page=' . $i }}">
                                    {{ $i }}</a>
                            @endfor
                            @if ($page + 3 < $total_pages)
                                <p>...</p>
                            @endif
                            <a class="px-4 py-2 rounded
                    {{ $page + 1 == $total_pages ? 'bg-darkGrey text-white' : '' }}"
                                href="{{ route('admin-signalements') . '?page=' . $total_pages }}">
                                {{ $total_pages }}</a>
                        </div>
                        <x-button.blue.clipboard-check
                            @click="window.location.href='{{ route('admin-signalements-traites') }}'">Signalements
                            traités</x-button.blue.clipboard-check>
                    </div>
                </div>
                <h2 class="text-2xl text-darkGrey">{{ $page * 50 + 1 }} à
                    {{ $page * 50 + 50 > $count ? $count : $page * 50 + 50 }} de {{ $count }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col grow overflow-auto">
                @foreach ($signalements as $signalement)
                    <div x-data='{openArticleModal: false}'
                        class="px-4 my-2 w-full h-fit py-4 bg-lightGrey rounded-[14px] p-1 shrink-0 flex">

                        <div class="flex w-7/12">
                            <div class="w-1/2">
                                <h3 class="text-2xl text-darkGrey">
                                    {{ $signalement->article->nom }}
                                    @if ($signalement->article->id_etat == 2)
                                        <span class="font-normal text-red-500"> (masqué)</span>
                                    @endif
                                </h3>
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset($signalement->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                        alt="{{ $signalement->article->artiste->nom_artiste }}"
                                        class="rounded-full w-[48px] h-[48px]">
                                    <form class="hover:underline" method="get"
                                        action="{{ route('admin-utilisateurs') }}">
                                        <input type="hidden" name="query"
                                            value="{{ $signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name }}">

                                        <x-button.none.empty>{{ $signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name }}
                                            @if (!$signalement->article->artiste->actif)
                                                <span class="text-red-500">(inactif)</span>
                                            @endif
                                        </x-button.none.empty>
                                    </form>
                                    @if ($signalement->article->artiste->actif)
                                        <a class="hover:underline flex w-fit items-center"
                                            href="{{ route('kiosque', ['idUser' => $signalement->article->artiste->id_user]) }}"
                                            target="_blank">
                                            <x-button.border.kiosque></x-button.border.kiosque>
                                        </a>
                                    @endif
                                </div>
                                <p class="italic">Signalé par <span>{{ $signalement->user->name }}</span> le
                                    <span>{{ $signalement->created_at }}</span>
                                </p>
                                <p><span class="font-bold">Commentaire :</span>
                                    <span>{{ $signalement->description }}</span>
                                </p>
                            </div>
                            <div class="w-1/2 flex flex-col items-center justify-around">
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
                                    quantite_disponible: '{{ htmlspecialchars($signalement->article->quantite_disponible) }}',
                                    is_unique: '{{ $signalement->article->is_unique }}',
                                    is_alimentaire: '{{ $signalement->article->is_alimentaire }}',
                                    is_sensible: '{{ $signalement->article->is_sensible }}',
                                });
                                 $dispatch('set-photos', '{{ $signalement->article->photo_article }}');
                                 $dispatch('set-mots-cles', '{{ $signalement->article->motCles }}'); ">Voir
                                    l'article</x-button.blue.leave>
                                <form method="get" action="{{ route('admin-utilisateurs') }}">
                                    <input type="hidden" name="query" value="{{ $signalement->user->name }}">
                                    <x-button.blue.leave>Voir le client</x-button.blue.leave>
                                </form>
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
                            <div class="h-full col-span-3 flex items-center" x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }">
                                <x-button.red.trash class="w-full"
                                    @click="
                            $dispatch('open-delete-modal');
                            $dispatch('set-id', {{ $signalement->article->id_article }});
                            $dispatch('set-signalement', {{ $signalement->id_signalement }});
                            $dispatch('set-name', {{ json_encode($signalement->article->nom) }});">Supprimer
                                    l'article</x-button.red.trash>
                            </div>
                            <div class="h-full
                                    col-span-2 flex items-center"
                                x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
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
            @include('admin.components.delete-signalement-modal')

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
