<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] w-4/5 flex flex-col">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="titre2-dark m-titreY p-sectionY border-b-2 border-darkGrey">Avertissements de
                    {{ $user->name }}</h1>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col grow overflow-auto mt-2 gap-4">
                @foreach ($user->avertissements() as $avertissement)
                    <div class="flex bg-lightGrey w-full rounded p-6 gap-6">
                        <p><span class="font-bold">Date:</span> {{$avertissement->date}}</p>
                        <p><span class="font-bold">Raison: </span> {{$avertissement->message}}</p>
                    </div>
                @endforeach
                @if($user->avertissements()->count() == 0)
                <p>Cet utilisateur n'a jamais été averti à date! </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
