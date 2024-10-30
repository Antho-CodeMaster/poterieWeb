<div x-cloak @open-demote-modal.window="openDemote = true;">
    <div x-show="openDemote" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0, name : '', admin : 0}" @set-id.window="id = $event.detail" @set-name.window="name = $event.detail" @set-role.window="admin = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="openDemote = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Rétrograder <span x-text="name">l'utilisateur</span>?</h2>

            <form method="POST" x-bind:action="'{{ route('admin-user-demote') }}?id=' + id">
                @csrf
                <p x-show="admin" class="text-darkGrey text-base w-full text-center"><span x-text="name">L'utilisateur</span> ne pourra plus supprimer d'utilisateurs, et ne pourra pas promouvoir/rétrograder d'autres utilisateurs.</p>
                <p x-show="!admin" class="text-darkGrey text-base w-full text-center"><span x-text="name">L'utilisateur</span> n'aura plus accès à l'interface d'administration dans son ensemble.</p>
                    <x-button.red.down class="mx-auto mt-4">Rétrograder</x-button.red.down>
            </form>
        </div>
    </div>
</div>
