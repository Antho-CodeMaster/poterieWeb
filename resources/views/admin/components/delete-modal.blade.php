<div x-cloak @open-delete-modal.window="openDelete = true;">
    <!-- Login Modal -->
    <div x-show="openDelete" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{id : 0, name : ''}" @set-id.window="id = $event.detail" @set-name.window="name = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button id="closeModal" @click="openDelete = false"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="text-left text-xl font-bold mb-6">Supprimer <span id="deleteUsername"
                    x-text="name">l'utilisateur</span>?</h2>

            <form method="POST" x-bind:action="'{{ route('admin-user-delete') }}?id=' + id">
                @csrf

                <p class="text-darkGrey text-s w-full text-center">Veuillez entrer le nom complet de l'utilisateur pour
                    confirmer sa suppression.</p>
                <x-text-input id="validateInput" class="w-full mt-6"></x-text-input>
                <button id="deleteButton" type="submit" disabled
                    class="h-10 w-fit px-4 mx-auto mt-4 shadow-inner rounded bg-darkGrey hover:bg-darkGrey flex">
                    <div class="m-auto flex gap-2">
                        <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path id="deleteSVG" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                        <p id="deleteP" class="text-xl text-white">Supprimer</p>
                    </div>
                </button>
                <p class="text-darkGrey text-xs w-full text-center mt-4"><span x-text="name">L'utilisateur</span> sera
                    immédiatement supprimé et ne pourra plus se connecter.</p>
            </form>
        </div>
    </div>
</div>
