<div x-cloak @open-signal-article-modal.window="openSignalArticleModal = true;" class="z-[2000]" x-data="{ article: {}, openSignalArticleModal: false }">
    {{-- Fond gris --}}
    <div x-show="openSignalArticleModal" @set-article-signal.window="article = JSON.parse($event.detail);"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white p-sectionX p-sectionY rounded-[12px] shadow-lg w-full max-w-[580px]">

            <section class="relative flex justify-center w-full h-[50px] items-center">
                <!-- Titre centré -->
                <p class="titre3-dark text-wrap text-center mb-2"> Signalement
                </p>
            </section>

            <section class="flex h-full justify-center p-sectionX">
                <form method="post" action="{{ route('signaleArticle') }}" id="signaleArticleForm"
                    enctype="multipart/form-data" class="w-full flex flex-wrap h-full justify-center gap-input">
                    @csrf
                    @method('POST')


                    <textarea name="signaleDescription" id="signaleDescription" rows="4" required
                        class="w-[80%] rounded resize-none bg-gray-50" placeholder="Veuillez indquer la raison de votre signalement"></textarea>

                    <input type="hidden" x-bind:value="article.id_article" name="idArticle">

                    <div class="w-full flex justify-center gap-3 mt-3">
                        <!-- Bouton de fermeture -->
                        <x-button.grey.empty @click="openSignalArticleModal = false"
                            class="h-[36px] text-[20px] w-[50%] text-center hover:bg-[#515151]" type="button" name="idArticle">
                            Annuler
                        </x-button.grey.empty>

                        <x-button.red.empty type="submit" name="id_article"
                            class="h-[36px] text-[20px] w-[50%] font-black text-center">
                            Signalement
                        </x-button.red.empty>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
