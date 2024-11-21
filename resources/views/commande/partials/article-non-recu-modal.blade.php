<div x-cloak @open-signal-article-modal.window="openSignalArticleModal = true;" class="z-[2000]" x-data="{ transaction: {}, openSignalArticleModal: false }">
    {{-- Fond gris --}}
    <div x-show="openSignalArticleModal" @set-transaction-signal.window="transaction = JSON.parse($event.detail); console.log(article)"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white p-sectionX p-sectionY rounded-[12px] shadow-lg w-full max-w-[580px]">

            <section class="relative flex justify-center w-full h-[50px] items-center">
                <!-- Titre centré -->
                <p class="titre3-dark text-wrap text-center mb-2"> Article non reçu !
                </p>
            </section>

            <section class="flex h-full justify-center p-sectionX">
                <form method="post" action="{{ route('article-non-recu') }}"
                    enctype="multipart/form-data" class="w-full flex flex-wrap h-full justify-center gap-input">
                    @csrf
                    @method('POST')
                    <p class="text-sm text-center">S'il y a eu une erreur avec votre commande ou si l'artiste ne vous a jamais livré votre article,
                        il est possible pour vous de signaler l'article comme non reçu afin que les administrateurs
                        investiguent la situation.</p>

                    <textarea name="signaleDescription" id="signaleDescription" rows="4" required
                        class="w-[80%] rounded resize-none bg-gray-50"
                        placeholder="Veuillez indiquer un commentaire qui permettrait aux administrateurs d'idenfier la source du problème."></textarea>

                    <input type="hidden" x-bind:value="transaction.id_transaction" name="id_transaction">

                    <div class="w-full flex justify-center gap-3 mt-3">
                        <!-- Bouton de fermeture -->
                        <x-button.grey.empty @click="openSignalArticleModal = false"
                            class="h-[36px] text-[20px] w-[50%] text-center hover:bg-[#515151]" type="button">
                            Annuler
                        </x-button.grey.empty>

                        <x-button.red.empty type="submit"
                            class="h-[36px] text-[20px] w-[50%] font-black text-center">
                            Envoyer pour vérification
                        </x-button.red.empty>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
