<x-app-layout>
    {{-- Modal de remerciement d'avoir envoyé une demande --}}
    @if (Session::has('firstaccess'))
        @include('components.kiosque-first-access-modal')
    @endif

    {{-- Section Bannière --}}
    @include('kiosque.partials.banniereKiosque')

    {{-- Section En vedette --}}
    <section class="m-collection" x-data='{openArticleModal: false}'>

        {{-- Vérifie si il y a des articles en vedette et affiche cette collection en fonction de cela --}}
        @if ($enVedette == true)
            <h2 class="titre2-dark mx-[16px] m-titreY select-none">En vedette</h2>
            @include('kiosque.partials.carroussel')
        @else
            @if (Auth::id() == $artiste->id_user)
                <h2 class="titre2-dark mx-[16px] m-titreY select-none">En vedette</h2>
                <div class="bg-beige p-sectionY">
                    <p class=" textGrand-dark mx-[16px] select-none font-bold">Pour le moment vous n'avez aucun article
                        en vedette.
                    </p>
                    @if ($hasArticle == false)
                        <a href="{{ route('tousMesArticles') }}" class=" textMoyen-dark underline mx-[16px]">Voici un
                            lien pour modifier un article afin de le rajouter dans la collection en vedette</a>
                    @else
                        <a href="{{ route('addArticleForm', ['idArticle' => 1]) }}"
                            class=" textMoyen-dark underline mx-[16px]">Voici un lien pour
                            ajouter un nouvelle article et le placer en vedette</a>
                    @endif
                </div>
            @endif
        @endif

    </section>

    {{-- Section Tous les articles --}}
    @include('kiosque.partials.tousLesArticles.tousMesArticleKiosque')

    {{-- Message de Session --}}
    {{-- Succes de la suppression d'un article --}}
    @if (Session::has('succesDeleteArticle'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesDeleteArticle'),
                'titre' => 'Suppression',
            ])
        </div>
    @endif

    {{-- Succes d'un signalement d'article --}}
    @if (Session::has('succesSignalement'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageSucces', [
                'message' => Session::get('succesSignalement'),
                'titre' => 'Signalement',
            ])
        </div>
    @endif

    {{-- Échec d'un signalement d'article --}}
    @if (Session::has('echecSignalement'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('echecSignalement'),
                'titre' => 'Signalement',
            ])
        </div>
    @endif

    {{-- Artiste inactif --}}
    @if (Session::has('errorInactif'))
        <div class="h-fit w-fit sticky bottom-2 right-0 ml-auto mr-2 mb-1 z-[1001]" role="alert">
            @include('messages.messageFail', [
                'message' => Session::get('errorInactif'),
                'titre' => 'Artiste pas trouvée',
            ])
        </div>
    @endif

</x-app-layout>


{{-- TODO: La partie responsive --}}


{{-- Fonction pour changer la couleur du texte en fonction du background --}}
{{-- Applique le style en fonction de la couleur de bannière --}}
<style>
    .dynamicText {
        color: white;
        /* Couleur du texte (et du SVG via currentColor) */
        filter: brightness(2);
        /* Applique un éclaircissement du texte et du SVG */
        mix-blend-mode: luminosity;
        /* Change la couleur du texte et du SVG selon la luminosité du fond */
    }
</style>
