<div x-cloak @open-article-modal.window="openArticleModal = true;"
    class="z-[1000] transition-all duration-200 ease-in-out" x-data="articleModal()">
    {{-- Fond gris --}}
    <div x-show="openArticleModal"
        @set-article.window="article = $event.detail; console.log('Modal ouvert'); currentIndex = 0;"
        @set-artiste.window="artiste = JSON.parse($event.detail);" @set-photos.window="photos = JSON.parse($event.detail)"
        @set-mots-cles.window="motsCles = JSON.parse($event.detail); console.log('Mots-clés mis à jour : ', this.motsCles);"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-[101]">

        <!-- Modal pour écran normal -->
        <div class="hidden md:block w-full">
            @include('kiosque.modal.modal-card')
        </div>

        <!-- Modal pour écran responsive -->
        <div class="md:hidden w-full">
            @include('kiosque.modal.modal-card-responsive')
        </div>
    </div>
</div>

<script>
    function articleModal() {
        return {
            openArticleModal: false,
            article: {},
            photos: [],
            artiste: {},
            motsCles: [],
            currentIndex: 0,

            closeModal() {
                this.openArticleModal = false;
                this.article = {};
                this.photos = [];
                this.motsCles = [];
                this.artiste = {};
            }
        }
    }
</script>
