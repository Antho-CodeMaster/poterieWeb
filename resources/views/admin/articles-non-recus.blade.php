<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] flex flex-col w-4/5" x-data="{ openAvertir: false, openDelete: false }">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="titre2-dark m-titreY p-sectionY border-b-2 border-darkGrey">Articles non reçus</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof($anrs) }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col grow overflow-auto">
                @foreach ($anrs as $anr)
                    <div x-data='{openArticleModal: false}'
                        class="px-4 my-2 w-full h-fit py-4 bg-lightGrey rounded-[14px] p-1 shrink-0 flex">

                        <div class="flex w-1/3">
                            <div class="">
                                <h3 class="text-2xl text-darkGrey">
                                    {{ $anr->transaction->article->nom }}
                                @if ($anr->transaction->quantite > 1)
                                ({{$anr->transaction->quantite}} exemplaires)
                                @endif</h3>
                                @if ($anr->transaction->article->artiste->actif)
                                    <a class="hover:underline flex w-fit items-center"
                                        href="{{ route('kiosque', ['idUser' => $anr->transaction->article->artiste->id_user]) }}"
                                        target="_blank">
                                        <img src="{{ asset($anr->transaction->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                            alt="{{ $anr->transaction->article->artiste->nom_artiste }}"
                                            class="rounded-full w-[48px] h-[48px]">
                                        <p>{{ $anr->transaction->article->artiste->nom_artiste ?? $anr->transaction->article->artiste->user->name }}
                                        </p>
                                    </a>
                                @else
                                    <div class="flex w-fit items-center">
                                        <img src="{{ asset($anr->transaction->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                            alt="{{ $anr->transaction->article->artiste->nom_artiste }}"
                                            class="rounded-full w-[48px] h-[48px]">
                                        <p>{{ $anr->transaction->article->artiste->nom_artiste ?? $anr->transaction->article->artiste->user->name }}
                                            <span class="text-red-500">(inactif)</span>
                                        </p>
                                    </div>
                                @endif
                                <p class="italic">Demandé par <span>{{ $anr->transaction->commande->user->name }}</span>
                                </p>
                                <p>Date de la demande: <span>{{ $anr->created_at }}</span></p>
                                <p>Commentaire: <span class="italic">{{ $anr->description }}</span></p>
                            </div>
                        </div>
                        <div class="w-1/3 flex flex-col justify-between">
                            <p class="textGrand-dark">
                                {{ number_format($anr->transaction->prix_unitaire * $anr->transaction->quantite, 2, ',', ' ') }}
                                $</p>

                            <form method="get" action="{{ $anr->transaction->commande->receipt_url }}">
                                <x-button.blue.clipboard-check>Voir la facture</x-button.blue.clipboard-check>
                            </form>

                            <form method="get" action="{{ route('admin-utilisateurs') }}">
                                <input type="hidden" name="query"
                                    value="{{ $anr->transaction->commande->user->name }}">
                                <x-button.blue.leave>Voir le client</x-button.blue.leave>
                            </form>
                        </div>
                        <div class="w-1/3 flex flex-col justify-between" x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }">

                            <p class="textGrand-dark">Payé le: <span>{{ $anr->transaction->created_at }}</span></p>

                            <form method="get" action="mailto:{{ $anr->transaction->commande->user->email }}">
                                @csrf
                                <x-button.blue.edit>Contacter le client</x-button.blue.edit>
                            </form>
                            <x-button.red.trash
                                @click="
                                $dispatch('open-delete-modal');
                                console.log(openDelete);
                                $dispatch('set-id', {{ $anr->id_signalement}});">Supprimer
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
