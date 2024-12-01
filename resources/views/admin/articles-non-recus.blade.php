<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] flex flex-col w-full" x-data="{ openAvertir: false, openDelete: false }">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <div class="flex items-center border-b-2 border-darkGrey gap-5 justify-between">
                    <h1 class="titre2-dark m-titreY p-sectionY">Articles non reçus</h1>
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
                                    href="{{ route('admin-articles-non-recus') . '?page=' . $i }}">
                                    {{ $i }}</a>
                            @endfor
                            @if ($page + 3 < $total_pages)
                                <p>...</p>
                            @endif
                            <a class="px-4 py-2 rounded
                    {{ $page + 1 == $total_pages ? 'bg-darkGrey text-white' : '' }}"
                                href="{{ route('admin-articles-non-recus') . '?page=' . $total_pages }}">
                                {{ $total_pages }}</a>
                        </div>
                        <x-button.blue.clipboard-check
                            @click="window.location.href='{{ route('admin-articles-non-recus-traites') }}'">Articles non
                            reçus traités</x-button.blue.clipboard-check>
                    </div>
                </div>
                <h2 class="text-2xl text-darkGrey">{{ $page * 50 + 1 }} à
                    {{ $page * 50 + 50 > $count ? $count : $page * 50 + 50 }} de {{ $count }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col grow overflow-auto">
                @if ($anrs->isEmpty())
                    <p class="text-center">Aucun signalement à afficher sur cette page.</p>
                @endif
                @foreach ($anrs as $anr)
                    <div x-data='{openArticleModal: false}'
                        class="px-4 my-2 w-full h-fit py-4 bg-lightGrey rounded-[14px] p-1 shrink-0 flex gap-3">

                        <div class="flex w-1/3">
                            <div class="">
                                <h3 class="text-2xl text-darkGrey">
                                    {{ $anr->transaction->article->nom }}
                                    @if ($anr->transaction->quantite > 1)
                                        ({{ $anr->transaction->quantite }} exemplaires)
                                    @endif
                                </h3>
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset($anr->transaction->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                        alt="{{ $anr->transaction->article->artiste->nom_artiste }}"
                                        class="rounded-full w-[48px] h-[48px]">
                                    <form class="hover:underline" method="get"
                                        action="{{ route('admin-utilisateurs') }}">
                                        <input type="hidden" name="query"
                                            value="{{ $anr->transaction->article->artiste->nom_artiste ?? $anr->transaction->article->artiste->user->name }}">

                                        <x-button.none.empty>{{ $anr->transaction->article->artiste->nom_artiste ?? $anr->transaction->article->artiste->user->name }}
                                            @if (!$anr->transaction->article->artiste->actif)
                                                <span class="text-red-500">(inactif)</span>
                                            @endif
                                        </x-button.none.empty>
                                    </form>
                                    @if ($anr->transaction->article->artiste->actif)
                                        <a class="hover:underline flex w-fit items-center"
                                            href="{{ route('kiosque', ['idUser' => $anr->transaction->article->artiste->id_user]) }}"
                                            target="_blank">
                                            <x-button.border.kiosque></x-button.border.kiosque>
                                        </a>
                                    @endif
                                </div>
                                <p class="italic">Demandé par
                                    <span>{{ $anr->transaction->commande->user->name }}</span>
                                </p>
                                <p><span class="font-bold">Date de la demande:</span>
                                    <span>{{ $anr->date }}</span>
                                </p>
                                <p><span class="font-bold">Commentaire: </span> <span
                                        class="italic">{{ $anr->description }}</span></p>
                            </div>
                        </div>
                        <div class="w-1/3 flex flex-col justify-between">
                            <p class="textGrand-dark">
                                {{ number_format($anr->transaction->prix_unitaire * $anr->transaction->quantite, 2, ',', ' ') }}
                                $</p>

                            <form method="get" action="{{ $anr->receipt_url }}">
                                <x-button.blue.clipboard-check>Voir la facture</x-button.blue.clipboard-check>
                            </form>

                            <form method="get" action="{{ route('admin-utilisateurs') }}">
                                <input type="hidden" name="query"
                                    value="{{ $anr->transaction->commande->user->name }}">
                                <x-button.blue.leave>Voir le client</x-button.blue.leave>
                            </form>
                        </div>
                        <div class="w-1/3 flex flex-col justify-between" x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }">

                            <p class="textGrand-dark">Payé le: <span>{{ $anr->transaction->commande->date }}</span></p>

                            <form method="get" action="mailto:{{ $anr->transaction->commande->user->email }}">
                                @csrf
                                <x-button.blue.edit>Contacter le client</x-button.blue.edit>
                            </form>
                            <x-button.red.trash
                                @click="
                            $dispatch('open-delete-modal');
                            console.log(openDelete);
                            $dispatch('set-id', {{ $anr->id_signalement }});">Supprimer
                                la demande</x-button.red.trash>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('admin.components.delete-anr-modal')

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
