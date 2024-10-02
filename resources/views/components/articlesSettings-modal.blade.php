<div x-cloak x-data="{ openArticleSettings: false }" @close-login-modal.window="openArticleSettings = false">
    <!-- Trigger Button for ArticleSettings Modal -->
    <button @click="openArticleSettings = true">
        <svg width="50" height="50" viewBox="0 0 126 126" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="mx-[16px]">
            <path
                d="M45.8125 125.5L43.3125 105.5C41.9583 104.979 40.6823 104.354 39.4844 103.625C38.2865 102.896 37.1146 102.115 35.9687 101.281L17.375 109.094L0.1875 79.4062L16.2813 67.2188C16.1771 66.4896 16.125 65.7865 16.125 65.1094V60.8906C16.125 60.2135 16.1771 59.5104 16.2813 58.7812L0.1875 46.5938L17.375 16.9062L35.9687 24.7188C37.1146 23.8854 38.3125 23.1042 39.5625 22.375C40.8125 21.6458 42.0625 21.0208 43.3125 20.5L45.8125 0.5H80.1875L82.6875 20.5C84.0417 21.0208 85.3177 21.6458 86.5156 22.375C87.7135 23.1042 88.8854 23.8854 90.0312 24.7188L108.625 16.9062L125.813 46.5938L109.719 58.7812C109.823 59.5104 109.875 60.2135 109.875 60.8906V65.1094C109.875 65.7865 109.771 66.4896 109.562 67.2188L125.656 79.4062L108.469 109.094L90.0312 101.281C88.8854 102.115 87.6875 102.896 86.4375 103.625C85.1875 104.354 83.9375 104.979 82.6875 105.5L80.1875 125.5H45.8125ZM63.3125 84.875C69.3542 84.875 74.5104 82.7396 78.7812 78.4688C83.0521 74.1979 85.1875 69.0417 85.1875 63C85.1875 56.9583 83.0521 51.8021 78.7812 47.5313C74.5104 43.2604 69.3542 41.125 63.3125 41.125C57.1667 41.125 51.9844 43.2604 47.7656 47.5313C43.5469 51.8021 41.4375 56.9583 41.4375 63C41.4375 69.0417 43.5469 74.1979 47.7656 78.4688C51.9844 82.7396 57.1667 84.875 63.3125 84.875Z"
                fill="#1D1B20" />
        </svg>
    </button>

    {{-- Fond gris --}}
    <div x-show="openArticleSettings"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white p-6 rounded-[12px] shadow-lg w-full max-w-[1100px] relative">

            {{-- ArticleSettings Nav --}}
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button id="ajouterArticle"
                        class="bg-darkGrey border-[2px] border-darkGrey text-beige font-bold text-[16px] p-[8px] rounded-t-[12px]">
                        Ajouter un
                        article </button>
                    <button id="tousMesArticles"
                        class="font-bold text-[16px] border-[2px] border-darkGrey p-[8px] rounded-t-[12px]"> Tous mes
                        articles </button>
                    <button id="articlesEnVedette"
                        class="font-bold text-[16px] border-[2px] border-darkGrey p-[8px] rounded-t-[12px]"> Articles en
                        vedette </button>
                    <button id="personnalisation"
                        class="font-bold text-[16px] border-[2px] border-darkGrey p-[8px] rounded-t-[12px]">
                        Personnalisation </button>
                </div>

                <!-- Close Button -->
                <button @click="openArticleSettings = false" class="hover:text-gray-900">
                    <svg class="w-10 h-10 text-gray-500 hover:text-gray-900" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </div>

            <div>
                @include('components.addArticle-modal')
            </div>

        </div>
    </div>
</div>
