<div class="bg-white">
    <form action="{{ route('artiste.updateColor') }}" method="POST" x-data="colorPicker()"
        x-init="[initColor('{{ isset($artiste->couleur_banniere) ? 'bg-' . $artiste->couleur_banniere : 'bg-neutral-500' }}')]">
        @csrf <!-- Include CSRF token for security -->
        <div>
            <label for="color-picker" class="block mb-1 font-semibold">Choisir la couleur de bannière du kiosque</label>
            <div class="flex flex-row relative">
                <!-- Input for the current color -->
                <input id="color-picker" class="border border-gray-400 p-2 rounded-lg" readonly x-model="currentColor">

                <!-- Hidden input to submit the selected color -->
                <input type="hidden" name="couleur_banniere" :value="currentColor">

                <!-- Color preview button that toggles the dropdown -->
                <div @click="isColorPickerOpen = !isColorPickerOpen"
                     class="cursor-pointer rounded-full ml-3 my-auto h-10 w-10 flex"
                     :class="currentColor">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         :class="iconColor"
                         class="h-6 w-6 mx-auto my-auto"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </div>

                <!-- Dropdown for color selection -->
                <div x-show="isColorPickerOpen"
                     @click.away="handleCloseDropdown"
                     class="absolute left-0 top-full mt-2 border border-gray-300 rounded-md shadow-lg bg-white p-2 z-30">
                    <div class="rounded-md bg-white shadow-xs p-2">
                        <div class="flex flex-wrap">
                            <template x-for="color in colors" :key="color">
                                <div class="flex flex-col">
                                    <!-- Iterate through variants for each color -->
                                    <template x-for="variant in variants" :key="variant">
                                        <!-- Color option button -->
                                        <div @click="selectColor(color, variant)"
                                             class="cursor-pointer w-6 h-6 rounded-full mx-1 my-1"
                                             :class="'bg-' + color + '-' + variant">
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center mt-2 gap-4">
            <x-primary-button class="hover:bg-lightVert bg-vert">{{ __('Sauvegarder') }}</x-primary-button>

            @if (session('status') === 'kiosque-color-updated')
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
</div>
