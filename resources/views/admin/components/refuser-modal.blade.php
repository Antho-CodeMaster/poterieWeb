<div x-cloak @open-refuser-modal.window="openRefuser = true;">
    <div x-show="openRefuser" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0, name : ''}" @set-id.window="id = $event.detail" @set-name.window="name = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="openRefuser = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Refuser la demande de <span x-text="name">l'utilisateur</span>?
            </h2>

            <form method="POST" x-bind:action="'{{ route('demande-deny') }}?id=' + id">
                @csrf
                <textarea maxlength="255" name="reason" class="rounded-xl resize-none w-full" placeholder="Entrez la raison ici..."></textarea>

                <p class="text-darkGrey text-xs w-full text-center"><span x-text="name">L'utilisateur</span> sera
                    immédiatement notifié du refus.</p>
                <x-button.red.x class="mx-auto mt-2"
                    >Refuser</x-button.red.x>
            </form>
        </div>
    </div>
</div>
