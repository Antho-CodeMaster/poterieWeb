<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Réseaux sociaux") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettre à jour vos différents réseaux sociaux.") }}
        </p>
    </header>

    <form method="post" action="{{ route('artiste.updateSocials') }}" class="mt-6 space-y-6" x-data="socialMediaHandler()">
        @csrf

        <!-- Container for Existing Social Media Fields -->
        <div class="space-y-4">
            @foreach ($reseaux as $reseau)
                <div class="flex space-x-4 items-center" :class="{ 'hidden': removedFields.some(field => field.id_reseau === {{ $reseau->pivot->id_reseau }} && field.username === '{{ $reseau->pivot->username }}') }">
                    <!-- Pre-filled Username Field -->
                    <input type="text" name="usernames[]" value="{{ $reseau->pivot->username }}" placeholder="Nom d'utilisateur" class="text-lg text-darkGrey h-12 px-4 border border-darkGrey rounded-md shadow-sm focus:outline-none focus:border-beige" required>

                    <!-- Pre-selected Social Network Dropdown -->
                    <select name="reseaux[]" class="text-lg text-darkGrey h-12 px-4 border border-darkGrey rounded-md shadow-sm focus:outline-none" required>
                        <option value="">{{ __('Sélectionnez un réseau') }}</option>
                        @foreach ($allReseaux as $optionReseau)
                            <option value="{{ $optionReseau->id_reseau }}" {{ $optionReseau->id_reseau == $reseau->id_reseau ? 'selected' : '' }}>
                                {{ $optionReseau->reseau }}
                            </option>
                        @endforeach
                    </select>

                    <!-- "Remove" Button for the Current Field -->
                    <button type="button" @click="removeExistingField({{ $reseau->pivot->id_reseau }}, '{{ $reseau->pivot->username }}')" class="text-darkGrey border border-darkGrey rounded px-4 py-2 hover:bg-darkGrey hover:text-beige">
                        Retirer
                    </button>
                </div>

                <!-- Hidden input to track removed fields -->
                <input type="hidden" :value="JSON.stringify(removedFields)" name="removed_fields" />
            @endforeach
        </div>

        <!-- Container for Dynamic Fields -->
        <div id="extend-field" class="space-y-4">
            <template x-for="(field, index) in fields" :key="index">
                <div class="flex space-x-4 items-center">
                    <!-- Username Input Field -->
                    <input type="text" x-model="field.username" placeholder="Nom d'utilisateur" name="usernames[]" class="text-lg text-darkGrey h-12 px-4 border border-darkGrey rounded-md shadow-sm focus:outline-none focus:border-beige" required>

                    <!-- Social Network Dropdown -->
                    <select x-model="field.reseau_id" name="reseaux[]" class="text-lg text-darkGrey h-12 px-4 border border-darkGrey rounded-md shadow-sm focus:outline-none" required>
                        <option value="">{{ __('Sélectionnez un réseau') }}</option>
                        @foreach ($allReseaux as $reseau)
                            <option :value="{{ $reseau->id_reseau }}">{{ $reseau->reseau }}</option>
                        @endforeach
                    </select>

                    <!-- "Remove" Button to delete the current field -->
                    <button type="button" @click="removeField(index)" class="text-darkGrey border border-darkGrey rounded px-4 py-2 hover:bg-darkGrey hover:text-beige">
                        Retirer
                    </button>
                </div>
            </template>
        </div>

        <!-- "Add" Button -->
        <button type="button" @click="addField()" class="bg-darkGrey text-beige border border-darkGrey hover:text-darkGrey px-4 py-2 rounded hover:bg-beige mb-4">
            Ajouter un réseau
        </button>

        <div class="flex items-center gap-4">
            <x-primary-button class="hover:bg-lightVert bg-vert">{{ __('Sauvegarder') }}</x-primary-button>

            @if (session('status') === 'social-media-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Sauvegardé.') }}</p>
            @endif
        </div>
    </form>
</section>
