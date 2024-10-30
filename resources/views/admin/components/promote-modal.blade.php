<div x-cloak @open-promote-modal.window="openPromote = true;">
    <div x-show="openPromote" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0, name : '', mod : 0}" @set-id.window="id = $event.detail" @set-name.window="name = $event.detail" @set-role.window="mod = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="openPromote = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Promouvoir <span x-text="name">l'utilisateur</span>?</h2>

            <form method="POST" x-bind:action="'{{ route('admin-user-promote') }}?id=' + id">
                @csrf
                <p x-show="mod" class="text-darkGrey text-base w-full text-center"><span x-text="name">L'utilisateur</span> pourra maintenant supprimer et promouvoir/rétrograder d'autres utilisateurs.</p>
                <p x-show="!mod" class="text-darkGrey text-base w-full text-center"><span x-text="name">L'utilisateur</span> aura maintenant accès à l'interface d'administration dans son ensemble. Ne donnez pas ces accès à un inconnu!</p>
                <x-button.green.award class="mx-auto mt-4">Promouvoir</x-button.green.award>
            </form>
        </div>
    </div>
</div>
