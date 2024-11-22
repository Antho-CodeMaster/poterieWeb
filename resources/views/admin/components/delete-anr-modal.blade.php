<div x-cloak @open-delete-modal.window="openDelete = true;">
    <div x-show="openDelete" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0}" @set-id.window="id = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button id="closeModal" @click="openDelete = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Supprimer la demande ?</h2>

            <p class="text-darkGrey text-xs w-full text-center my-4">Assurez-vous d'avoir contacté le client afin de donner suite à sa demande. Il recevra une notification lui disant qu'il devrait s'attendre à un courriel.</p>

            <form method="POST" action="{{ route('admin-articles-non-recus-delete') }}">
                @csrf
                <input class="hidden" name="id" x-bind:value="id">
                <x-button.red.trash class="mx-auto">Supprimer</x-button.red.trash>
                <p class="text-darkGrey text-xs w-full text-center mt-4">La demande sera
                    immédiatement supprimée et le client en sera notifié.</p>
            </form>
        </div>
    </div>
</div>
