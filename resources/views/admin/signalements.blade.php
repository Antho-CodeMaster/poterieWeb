<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] flex flex-col w-4/5" x-data="{ openAvertir: false}">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="titre2-dark m-titreY p-sectionY border-b-2 border-darkGrey">Signalements</h1>
                <h2 class="text-2xl text-darkGrey">{{ sizeof($signalements) }} résultats</h2>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col grow overflow-auto">
                @foreach ($signalements as $signalement)
                    <div class="px-4 my-2 w-full h-1/5 bg-lightGrey rounded-[14px] p-1 shrink-0 flex">
                        <div class="w-2/3">
                            <h3 class="text-2xl text-darkGrey">{{ $signalement->article->nom }}</h3>
                            <div class="flex items-center">
                                <img src="{{ asset($signalement->article->artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}"
                                    alt="{{ $signalement->article->artiste->nom_artiste }}"
                                    class="rounded-full w-[48px] h-[48px]">
                                <p>{{ $signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name }}</p>
                            </div>
                            <p>Signalé par : {{ $signalement->user->name }}</p>
                            <p>Commentaire : {{ $signalement->description }}</p>
                        </div>
                        <div class="w-1/3 grid grid-cols-2 gap-x-6">
                            <x-button.blue.leave class="w-full">Voir l'article</x-button.blue.leave>
                            <div class="h-fit" x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
                                <x-button.yellow.exclamation class="w-full"
                                    @click="
                                $dispatch('open-avertir-modal');
                                $dispatch('set-id', {{ $signalement->article->artiste->id_user }});
                                $dispatch('set-name', {{ json_encode($signalement->article->artiste->nom_artiste ?? $signalement->article->artiste->user->name) }});
                                ">Avertir l'artiste</x-button.yellow.exclamation>
                            </div>
                            <form action="{{ route('kiosque', ['idUser' => $signalement->article->artiste->id_user]) }}"
                                method="GET" target="_blank">
                                <x-button.blue.leave class="w-full">Voir le kiosque</x-button.blue.leave>
                            </form>
                            <div class="h-fit" x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }">
                                <x-button.yellow.exclamation class="w-full"
                                    @click="
                                $dispatch('open-avertir-modal');
                                $dispatch('set-id', {{ $signalement->id_user }});
                                $dispatch('set-name', {{ json_encode($signalement->user->name) }});
                                ">Avertir le client</x-button.yellow.exclamation>
                            </div>
                            <form action="{{ route('admin-signalements-delete') }}" method="POST">
                                @csrf
                                <input class="hidden" name="id" value={{ $signalement->id_signalement }}>
                                <input class="hidden" name="id_article" value={{ $signalement->article->id_article }}>
                                <x-button.red.trash class="w-full">Supprimer</x-button.red.trash>
                            </form>
                            <form action="{{ route('admin-signalements-delete') }}" method="POST">
                                @csrf
                                <input class="hidden" name="id" value={{ $signalement->id_signalement }}>
                                <x-button.green.check class="w-full">Ignorer</x-button.green.check>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('admin.components.avertir-modal')
    </div>
    </div>
</x-app-layout>
