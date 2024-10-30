<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pt-20 px-20 h-[100%] w-4/5 flex flex-col">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="text-4xl text-black">Renouvellement</h1>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="w-full content-height flex items-center justify-center">
                <div class="flex flex-col items-center">
                    <p>Renvoyer un message à tous les artistes étudiants afin de leur demander de re-soumettre une
                        preuve?</p>
                    <form method="POST" action="{{ route('admin-do-renouvellement') }}">
                        @csrf
                        <x-button.green.send class="my-12">Renouveler</x-button.green.send>
                    </form>
                    <p>Renouveler partira un timer d'un mois sans quoi les étudiants qui n'ont pas soumis de demande
                        perdront leur statut d'artiste.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
