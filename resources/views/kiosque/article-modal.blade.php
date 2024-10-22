<div x-cloak @open-article-modal.window="openArticleModal = true;" class="z-[1000]" x-data="{ article: {}, photos: [], motsCles: [], currentIndex: 0 }">
    {{-- Fond gris --}}
    <div x-show="openArticleModal" @set-article.window="article = JSON.parse($event.detail); console.log('Modal ouvert');"
        @set-photos.window="photos = JSON.parse($event.detail)"
        @set-mots-cles.window="motsCles = JSON.parse($event.detail); console.log('Mots-clés mis à jour : ', this.motsCles);"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white p-sectionX p-sectionY rounded-[12px] shadow-lg w-full max-w-[1080px]">

            <section class="relative flex justify-center w-full border h-[50px] items-center">
                <!-- Titre centré -->
                <h1 class="titre2-dark absolute left-1/2 transform -translate-x-1/2 border w-full text-center"
                    x-text="article.nom"></h1>

                <!-- Bouton de fermeture -->
                <button @click="openArticleModal = false" class="ml-auto hover:text-gray-600 border absolute right-0">
                    <svg class="w-9 h-9" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </section>

            <section class="flex">
                {{-- Affichage des photos --}}
                <div class="w-[540px] h-fit m-sectionY">
                    <div x-data="{ currentIndex: 0 }" class="w-full h-[400px] flex items-center justify-between m-sectionY">

                        {{-- Flèche gauche --}}
                        <svg id="prevBtn" @click="currentIndex = (currentIndex - 1 + photos.length) % photos.length"
                            class="text-darkGrey cursor-pointer transition-transform duration-300 hover:scale-110"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                            fill="none" viewBox="4 4 16 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m15 19-7-7 7-7" />
                        </svg>

                        {{-- Conteneur d'images --}}
                        <div class="flex relative w-full h-full justify-center">
                            <template x-for="(photo, index) in photos" :key="photo.id_photo">
                                <img :src="'/../img/' + photo.path" alt="Photo d'article"
                                    class="absolute w-[400px] h-[400px] object-cover transition-opacity duration-300 rounded shadow-lg"
                                    x-show="currentIndex === index"
                                    x-transition:enter="transition-opacity ease-in duration-400"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition-opacity ease-out duration-400"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" />
                            </template>
                        </div>

                        {{-- Flèche droite --}}
                        <svg id="nextBtn" @click="currentIndex = (currentIndex + 1) % photos.length"
                            class="text-darkGrey cursor-pointer transition-transform duration-300 hover:scale-110"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                            fill="none" viewBox="4 4 16 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m9 5 7 7-7 7" />
                        </svg>
                    </div>

                    {{-- Dimension --}}
                    <div class="mt-5 flex w-full gap-input p-sectionX">
                        <div>
                        {{-- Poids --}}
                        <div class="flex gap-1 items-baseline">
                            <p class=" articleGrand-dark">Poids:</p>
                            <div class="flex">
                                <p class=" articlePetit-dark" x-text="article.poids"></p>
                                <p class=" articlePetit-dark">g</p>
                            </div>
                        </div>

                        {{-- Longueur --}}
                        <div class="flex gap-1 items-baseline">
                            <p class=" articleGrand-dark">Largeur:</p>
                            <div class="flex">
                                <p class=" articlePetit-dark" x-text="article.largeur"></p>
                                <p class=" articlePetit-dark">cm</p>
                            </div>
                        </div>
                    </div>

                        <div>
                            {{-- Hauteur --}}
                            <div class="flex gap-1 items-baseline">
                                <p class=" articleGrand-dark">Hauteur:</p>
                                <div class="flex">
                                    <p class=" articlePetit-dark" x-text="article.hauteur"></p>
                                    <p class=" articlePetit-dark">cm</p>
                                </div>
                            </div>

                            {{-- Profondeur --}}
                            <div class="flex gap-1 items-baseline">
                                <p class=" articleGrand-dark">Profondeur:</p>
                                <div class="flex">
                                    <p class=" articlePetit-dark" x-text="article.profondeur"></p>
                                    <p class=" articlePetit-dark">cm</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <template x-if="motsCles.length > 0">
                        <div class="flex gap-2">
                            <template x-for="(motCle, index) in motsCles" :key="index">
                                <div>
                                    <p class="" x-text="motCle.mot_cle"></p>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="motsCles.length == 0">
                        <p>Aucun mot-clé disponible.</p>
                    </template>
                </div>
            </section>

        </div>
    </div>
</div>
