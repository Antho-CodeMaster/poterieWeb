<div x-cloak @open-article-modal.window="openArticleModal = true;">
    {{-- Fond gris --}}
    <div x-show="openArticleModal" x-data="{ article: {} }" @set-article.window = "article = $event.detail"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white p-sectionX p-sectionY rounded-[12px] shadow-lg w-full max-w-[1080px]">

            <section class="relative flex justify-center w-full border h-[50px] items-center">
                <!-- Titre centré -->
                <h1 class="titre2-dark absolute left-1/2 transform -translate-x-1/2 border" x-text="article.nom"></h1>

                <!-- Bouton de fermeture -->
                <button @click="openArticleModal = false" class="ml-auto hover:text-gray-600 border absolute right-0">
                    <svg class="w-9 h-9" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </section>

            <section>
                <div>
                    <template x-for="photo in article.photo_article" :key="photo.id">
                        <img :src="'/../img/' + photo" alt="Photo d'article"
                            class="z-1 shadow-md shadow-rounded rounded-[12px] cursor-pointer h-[160px] w-full object-cover hover:scale-[103%] hover:shadow-md hoverrounded-[16px] transition-all ease-in-out duration-200">
                    </template>
                </div>
                <div>

                </div>
            </section>
        </div>
    </div>
</div>
