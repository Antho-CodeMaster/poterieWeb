<div x-cloak @open-delete-modal.window="openDelete = true;">
    <div x-show="openDelete" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0, signalement : 0, name : ''}" @set-id.window="id = $event.detail" @set-name.window="name = $event.detail" @set-signalement.window="signalement = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button id="closeModal" @click="openDelete = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Supprimer <span
                    x-text="name">l'article</span>?</h2>

            <form method="POST" action="{{ route('admin-signalements-delete') }}">
                @csrf
                <input class="hidden" name="id_article" x-bind:value="id">
                <input class="hidden" name="id" x-bind:value="signalement">
                <x-button.red.trash class="mx-auto">Supprimer</x-button.red.trash>
                <p class="text-darkGrey text-xs w-full text-center mt-4">L'article et le signalement seront
                    immédiatement supprimés et l'artiste en sera notifié.</p>
            </form>
        </div>
    </div>
</div>
