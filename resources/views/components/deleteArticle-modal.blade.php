<div x-cloak @open-delete-article-modal.window="openDeleteArticle = true;">
    {{-- Fond gris --}}
    <div x-show="openDeleteArticle" x-data="{ id: 0 }" @set-id.window = "id = $event.detail"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white px-5 py-10 rounded-[12px] shadow-lg w-full max-w-[620px]">

            {{-- Logo de suppression --}}
            <div class="w-full flex justify-center mb-4">
                <svg class="w-14 h-14 text-rouge border-[2px] border-rouge rounded-[99px]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>

            {{-- Texte de confirmation --}}
            <div class="">
                <p class="textGrand-dark text-wrap text-center mb-2">Êtes vous sûr de vouloir supprimer cette
                    article?
                </p>
                <p class=" textPetit-dark text-center text-wrap">Ceci supprimera l'article définitivement de votre liste
                    d'article sans
                    possibilité de retrouver cette
                    article</p>
            </div>

            {{-- Boutons --}}
            <div class="w-full flex justify-center gap-3  mt-6">
                <!-- Close Button -->
                <x-button.grey.empty @click="openDeleteArticle = false" class="font-bold" name="idArticle" x-bind:value="id">
                    Annuler la suppression
                </x-button.grey.empty>

                <form action="{{ route('deleteArticle') }}" method="POST" class="">
                    @csrf @method('PATCH')

                    <input type="hidden" name="idUser" value="{{ Auth::user()->id }}">

                    <x-button.red.empty class="font-bold" name="idArticle" x-bind:value="id">
                        Confirmer la suppression
                    </x-button.red.empty>
                </form>


            </div>
        </div>
    </div>
</div>
