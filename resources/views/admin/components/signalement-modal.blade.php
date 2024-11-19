<div x-cloak @open-article-modal.window="openArticleModal = true;"
    class="z-[1000] transition-all duration-200 ease-in-out" x-data="articleModal()">
    {{-- Fond gris --}}
    <div x-show="openArticleModal" @set-article.window="article = $event.detail; console.log(article); currentIndex = 0;"
        @set-signalement.window="signalement = $event.detail; console.log(signalement)"
        @set-photos.window="photos = JSON.parse($event.detail)"
        @set-mots-cles.window="motsCles = JSON.parse($event.detail); console.log('Mots-clés mis à jour : ', this.motsCles);"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-[101]">

        {{-- modal card --}}
        <div class="bg-white p-sectionX p-sectionY rounded-[12px] shadow-lg w-full max-w-[1080px]">

            <section class="relative flex w-full h-[50px] items-center m-sectionY">
                <!-- Titre centré -->
                <p class=" select-none titre2-dark w-full text-center text-ellipsis text-wrap px-7"
                    x-html="article.nom"></p>

                <!-- Bouton de fermeture -->
                <button @click="closeModal(); index = 0" class="absolute right-0 hover:scale-110 duration-200">
                    <svg class="w-9 h-9" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>
            </section>

            <section class="flex h-full p-sectionX">
                {{-- Affichage des photos --}}
                <div class="w-[580px] h-fit m-sectionY">
                    <div x-data="{ currentIndex: 0 }" class="w-full h-[400px] flex items-center justify-between">

                        {{-- Flèche gauche --}}
                        <template x-if="photos.length == 1">
                            <svg id="prevBtn"
                                @click="currentIndex = (currentIndex - 1 + photos.length) % photos.length"
                                class="text-darkGrey cursor-pointer transition-transform duration-300 hover:scale-110"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                                fill="none" viewBox="4 4 16 16">
                                <path stroke="#c7c7c7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m15 19-7-7 7-7" />
                            </svg>
                        </template>
                        <template x-if="photos.length > 1">
                            <svg id="prevBtn"
                                @click="currentIndex = (currentIndex - 1 + photos.length) % photos.length"
                                class="text-darkGrey cursor-pointer transition-transform duration-300 hover:scale-110"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                                fill="none" viewBox="4 4 16 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m15 19-7-7 7-7" />
                            </svg>
                        </template>

                        {{-- Conteneur d'images --}}
                        <div class="flex relative w-full h-full justify-center overflow-hidden rounded">

                            <!-- Connecté et user insensible -->
                            <template x-for="(photo, index) in photos" :key="photo.id_photo">
                                <img :src="'/../img/' + photo.path" alt="Photo d'article"
                                    class="absolute w-[450px] h-[400px] object-cover transition-opacity duration-300 rounded select-none"
                                    :class="(article.quantite_disponible < 1 ? 'brightness-[35%]' : '') +
                                    (article.id_etat == 2 ? ' brightness-[35%]' : '')"
                                    x-show="currentIndex === index"
                                    x-transition:enter="transition-opacity ease-in duration-400"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition-opacity ease-out duration-400"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" />
                            </template>
                        </div>


                        {{-- Flèche droite --}}
                        <template x-if="photos.length == 1">
                            <svg id="nextBtn" @click="currentIndex = (currentIndex + 1) % photos.length"
                                class="text-darkGrey cursor-pointer transition-transform duration-300 hover:scale-110"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                                fill="none" viewBox="4 4 16 16">
                                <path stroke="#c7c7c7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d=" m9 5 7 7-7 7" />
                            </svg>
                        </template>
                        <template x-if="photos.length > 1">
                            <svg id="nextBtn" @click="currentIndex = (currentIndex + 1) % photos.length"
                                class="text-darkGrey cursor-pointer transition-transform duration-300 hover:scale-110"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                                fill="none" viewBox="4 4 16 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m9 5 7 7-7 7" />
                            </svg>
                        </template>
                    </div>

                    {{-- Dimension --}}
                    <div class="mt-5 flex flex-wrap w-full items-baseline">
                        <p class="titre3-dark w-full">Détails</p>
                        <div class="">
                            {{-- Poids --}}
                            <template x-if="article.poids !== null && article.poids > 0">
                                <div class="flex gap-1 items-baseline">
                                    <p class=" articleGrand-dark">Poids:</p>
                                    <div class="flex">
                                        <p class=" articlePetit-dark" x-text="article.poids"></p>
                                        <p class=" articlePetit-dark ml-0.5">g</p>
                                    </div>
                                </div>
                            </template>

                            {{-- Longueur --}}
                            <div class="flex gap-1 items-baseline">
                                <p class="articleGrand-dark">Largeur :</p>
                                <div x-data="{ units: {{ Auth::check() ? Auth::user()->units : 0 }}, isAuthenticated: {{ Auth::check() ? 'true' : 'false' }} }">

                                    <!-- Affichage en pouces si l'unité est définie sur pouces et utilisateur connecté -->
                                    <template x-if="isAuthenticated && units == 1">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="(article.largeur / 2.54).toFixed(2)">
                                            </p>
                                            <p class="articlePetit-dark ml-0.5">po</p>
                                        </div>
                                    </template>

                                    <!-- Affichage en centimètres si l'unité est définie sur centimètres et utilisateur connecté -->
                                    <template x-if="isAuthenticated && units == 0">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="article.largeur"></p>
                                            <p class="articlePetit-dark ml-0.5">cm</p>
                                        </div>
                                    </template>

                                    <!-- Affichage pour les utilisateurs non authentifiés (par défaut en cm) -->
                                    <template x-if="!isAuthenticated">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="article.largeur"></p>
                                            <p class="articlePetit-dark ml-0.5">cm</p>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </div>

                        <div class="ml-2">

                            {{-- Hauteur --}}
                            <div class="flex gap-1 items-baseline">
                                <p class="articleGrand-dark">Hauteur :</p>
                                <div x-data="{ units: {{ Auth::check() ? Auth::user()->units : 0 }}, isAuthenticated: {{ Auth::check() ? 'true' : 'false' }} }">

                                    <!-- Affichage en pouces si l'unité est définie sur pouces et utilisateur connecté -->
                                    <template x-if="isAuthenticated && units == 1">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="(article.hauteur / 2.54).toFixed(2)">
                                            </p>
                                            <p class="articlePetit-dark ml-0.5">po</p>
                                        </div>
                                    </template>

                                    <!-- Affichage en centimètres si l'unité est définie sur centimètres et utilisateur connecté -->
                                    <template x-if="isAuthenticated && units == 0">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="article.hauteur"></p>
                                            <p class="articlePetit-dark ml-0.5">cm</p>
                                        </div>
                                    </template>

                                    <!-- Affichage pour les utilisateurs non authentifiés (par défaut en cm) -->
                                    <template x-if="!isAuthenticated">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="article.hauteur"></p>
                                            <p class="articlePetit-dark ml-0.5">cm</p>
                                        </div>
                                    </template>

                                </div>
                            </div>

                            {{-- Profondeur --}}
                            <div class="flex gap-1 items-baseline">
                                <p class="articleGrand-dark">Profondeur :</p>
                                <div x-data="{ units: {{ Auth::check() ? Auth::user()->units : 0 }}, isAuthenticated: {{ Auth::check() ? 'true' : 'false' }} }">

                                    <!-- Affichage en pouces si l'unité est définie sur pouces et utilisateur connecté -->
                                    <template x-if="isAuthenticated && units == 1">
                                        <div class="flex">
                                            <p class="articlePetit-dark"
                                                x-text="(article.profondeur / 2.54).toFixed(2)"></p>
                                            <p class="articlePetit-dark ml-0.5">po</p>
                                        </div>
                                    </template>

                                    <!-- Affichage en centimètres si l'unité est définie sur centimètres et utilisateur connecté -->
                                    <template x-if="isAuthenticated && units == 0">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="article.profondeur"></p>
                                            <p class="articlePetit-dark ml-0.5">cm</p>
                                        </div>
                                    </template>

                                    <!-- Affichage pour les utilisateurs non authentifiés (par défaut en cm) -->
                                    <template x-if="!isAuthenticated">
                                        <div class="flex">
                                            <p class="articlePetit-dark" x-text="article.profondeur"></p>
                                            <p class="articlePetit-dark ml-0.5">cm</p>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between w-[490px] ml-2 m-sectionY" x-data="{ openSignalArticleModal: false }">
                    <div class="w-full flex flex-wrap gap-input">
                        {{-- Description --}}
                        <div class="flex flex-wrap w-full m-titreY">
                            <p class="titre3-dark w-full ">Description</p>
                            <p class="textGrand-dark " x-text="article.description"></p>
                        </div>

                        {{-- Mots clés --}}
                        <div class="flex flex-wrap w-full m-titreY">
                            <p class="titre3-dark w-full ">Mots clés</p>
                            <template x-if="motsCles.length > 0">
                                <div class="flex gap-2 overflow-auto">
                                    <template x-for="(motCle, index) in motsCles" :key="index">
                                        <div class="flex">
                                            <p class=" textGrand-dark bg-beigeFoncé rounded-md p-2"
                                                x-text="motCle.mot_cle"></p>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="motsCles.length == 0">
                                <p class=" textGrand-dark">Aucun mot-clé disponible.</p>
                            </template>
                        </div>

                        {{-- Types --}}
                        <div class="flex flex-wrap m-titreY w-full items-baseline">
                            <p class="titre3-dark mr-1 ">Pièce :</p>
                            <template x-if="article.is_unique == 1">
                                <p class="titre3-dark">Unique</p>
                            </template>

                            <template x-if="article.is_unique == 0">
                                <p class="titre3-dark">En série</p>
                            </template>
                        </div>

                        <div class="w-full m-titreY">
                            <template x-if="article.is_alimentaire == 1">
                                <p class="titre3-dark">Alimentaire</p>
                            </template>

                            <template x-if="article.is_alimentaire == 0">
                                <p class="titre3-dark">Non alimentaire</p>
                            </template>
                        </div>

                        {{-- Quantite --}}
                        <div class="flex flex-wrap w-full gap-1 m-titreY items-baseline">
                            <p class="titre3-dark mr-1">Quantité :</p>
                            <p class=" articleGrand-dark bg-beigeFoncé rounded-md py-[1px] px-[14px]"
                                x-text="article.quantite_disponible"></p>
                        </div>
                        <div class="border border-black rounded p-4 w-full">
                            <p class="titre3-dark mr-1 text-center mb-2">Signalement</p>
                            <p><span class="font-bold">Signalé par :</span> <span
                                    x-html="signalement.client">N/A</span></p>
                            <p><span class="font-bold">Commentaire :</span> <span
                                    x-html="signalement.raison">N/A</span></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function articleModal() {
        return {
            openArticleModal: false,
            article: {},
            photos: [],
            signalement: {},
            motsCles: [],
            currentIndex: 0,

            closeModal() {
                this.openArticleModal = false;
                this.article = {};
                this.photos = [];
                this.motsCles = [];
                this.client = {};
                this.raison = {};
            }
        }
    }
</script>