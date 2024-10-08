<div x-cloak x-data="{ openDeleteArticle: false }" @close-login-modal.window="openDeleteArticle = false">
    <!-- Trigger Button for DeleteArticle Modal -->
    <button @click="openDeleteArticle = true">
        <svg class="w-9 h-9 text-blue-900 hover:text-red-600  absolute top-0 right-0" width="40" height="44" viewBox="0 0 40 44" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2 10H6M6 10H38M6 10V38C6 39.0609 6.42143 40.0783 7.17157 40.8284C7.92172 41.5786 8.93913 42 10 42H30C31.0609 42 32.0783 41.5786 32.8284 40.8284C33.5786 40.0783 34 39.0609 34 38V10M12 10V6C12 4.93913 12.4214 3.92172 13.1716 3.17157C13.9217 2.42143 14.9391 2 16 2H24C25.0609 2 26.0783 2.42143 26.8284 3.17157C27.5786 3.92172 28 4.93913 28 6V10M16 20V32M24 20V32"
                stroke="#FC6262" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class=""/>
        </svg>

    </button>

    {{-- Fond gris --}}
    <div x-show="openDeleteArticle"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">

        {{-- modal card --}}
        <div class="bg-white px-5 py-10 rounded-[12px] shadow-lg w-full max-w-[620px]">

            <div class="w-full flex justify-center mb-4">
                <svg class="w-14 h-14 text-rouge border-[2px] border-rouge rounded-[99px]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </div>

            <div class="">
                <p class="font-medium text-[24px] text-wrap text-center">Êtes vous sûr de vouloir supprimer cette
                    article?
                </p>
                <p class="text-center text-wrap">Ceci supprimera l'article définitivement de votre liste d'article sans
                    possibilité de retrouver cette
                    article</p>
            </div>

            <div class="w-full flex justify-center gap-3  mt-6">
                <!-- Close Button -->
                <button @click="openDeleteArticle = false"
                    class="bg-gray-500 hover:bg-gray-700 p-2 rounded text-white font-bold">
                    Annuler la suppresion
                </button>

                <form action="{{ route('deleteArticle') }}" method="POST" class="">
                    @csrf @method('PATCH')

                    <input type="hidden" name="idUser" value="{{ Auth::user()->id }}">
                    <button type="submit" class="bg-[#F44336] hover:bg-[#D32F2F] p-2 rounded text-white font-bold"
                        name="idArticle" value="{{ $article->id_article }}">
                        Confirmer la suppression
                    </button>
                </form>


            </div>
        </div>
    </div>
</div>
