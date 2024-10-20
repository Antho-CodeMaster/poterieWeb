<div x-cloak @open-article-modal.window="openArticleModal = true;">
    {{-- Fond gris --}}
    <div x-show="openArticleModal" x-data="{ article: {} }" @set-article.window = "article = $event.detail"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white px-5 py-10 rounded-[12px] shadow-lg w-full max-w-[1080px]">

            <div class="mt-3">
                <p>Prix : <span x-text="article.prix"></span> $</p>
                <p>Hauteur : <span x-text="article.hauteur"></span> cm</p>
                <p>Description : <span x-text="article.description"></span></p>
            </div>

            {{-- Boutons --}}
            <div class="w-full flex justify-center gap-3  mt-6">
                <!-- Close Button -->
                <x-button.grey.empty @click="openArticleModal = false" class="font-bold" name="idArticle" >
                    Annuler la suppression
                </x-button.grey.empty>
            </div>
        </div>
    </div>
</div>
