<x-app-layout>
    <!-- Div qui divise le menu de gauche et le contenu-->
    <div class="flex content-height">
        @include('admin.menu-gauche')
        <!-- Partie de droite (contenu de la page) -->
        <div class="pr-10 h-[100%] w-4/5 flex flex-col">
            <!-- Titre, nombre de résultats, filtres-->
            <div id="header-info">
                <h1 class="titre2-dark m-titreY p-sectionY border-b-2 border-darkGrey">Renouvellement</h1>
            </div>
            <!-- Reste du contenu va ici-->
            <div class="flex flex-col items-center justify-start p-10">
                <p>Renvoyer un message à tous les artistes étudiants afin de leur demander de re-soumettre une
                    preuve?</p>
                <form method="POST" action="{{ route('admin-do-renouvellement') }}">
                    @csrf
                    <x-button.green.send class="my-6">Renouveler</x-button.green.send>
                </form>
                <p>Renouveler enverra un courriel et une notification à tous les artistes étudiants. Les étudiants,
                    une fois avertis, disposeront d'un mois pour faire une demande de renouvellement sans quoi les
                    étudiants qui n'ont pas soumis de demande
                    perdront leur statut d'artiste.</p>
            </div>
            <div class="flex flex-col grow overflow-y-auto">
                <h1 class="titre3-dark text-center m-titreY p-sectionY">Renouvellements passés</h1>
                <div class="overflow-y-auto flex flex-col grow items-center">
                    @foreach ($renouvellements as $renouvellement)
                        <div class="px-4 my-2 w-1/4 bg-lightGrey rounded-[14px] flex py-2 gap-3 shrink-0">
                            <p class="text-center w-full">{{ $renouvellement->created_at }}</p>
                        </div>
                    @endforeach
                    @if ($renouvellements->isEmpty())
                        <p class="text-center">Aucun renouvellement à date.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
