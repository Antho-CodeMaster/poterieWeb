<div x-cloak @open-retrieve-modal.window="openRetrieve = true;">
    <div x-show="openRetrieve" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0, name : ''}" @set-id.window="id = $event.detail" @set-name.window="name = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button id="closeModal" @click="openRetrieve = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Remettre <span
                    x-text="name">l'article</span> en ligne?</h2>

            <form method="POST" action="{{ route('admin-article-retrieve') }}">
                @csrf
                <input class="hidden" name="id_article" x-bind:value="id">
                <x-button.green.plus class="mx-auto">Remettre en ligne</x-button.green.plus>
                <p class="text-darkGrey text-xs w-full text-center mt-4">L'article sera
                    immédiatement remis en ligne (mais masqué aux clients) et l'artiste en sera notifié.</p>
            </form>
        </div>
    </div>
</div>
