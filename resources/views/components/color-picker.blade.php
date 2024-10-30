<div class="bg-white mx-auto my-auto p-6">
    <div x-data="colorPicker()" x-init="[initColor()]">
        <div>
            <label for="color-picker" class="block mb-1 font-semibold">Choisir une couleur</label>
            <div class="flex flex-row relative">
                <!-- Input for the current color -->
                <input id="color-picker" class="border border-gray-400 p-2 rounded-lg" readonly x-model="currentColor">

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
                     class="absolute right-0 top-full mt-2 border border-gray-300 rounded-md shadow-lg bg-white p-2 z-30">
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
    </div>
</div>

<!-- Script -->
<script>
    function colorPicker() {
        return {
            colors: ['slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'],
            variants: [100, 200, 300, 400, 500, 600, 700, 800, 900],
            currentColor: '',
            iconColor: '',
            isColorPickerOpen: false, // Renamed to make it more specific

            initColor() {
                this.currentColor = 'bg-emerald-400'; // Initialize with default color
                this.setIconBlack(); // Set default icon color
                console.log(this.colors); // Log colors once on init
                console.log(this.variants); // Log variants once on init
            },

            setIconWhite() {
                this.iconColor = 'text-beige'; // Set icon color to white for dark background
            },

            setIconBlack() {
                this.iconColor = 'text-darkGrey'; // Set icon color to black for light background
            },

            selectColor(color, variant) {
                console.log("Lists : ", this.colors.length, this.variants.length);
                this.currentColor = `bg-${color}-${variant}`; // Update the color with backticks

                if (variant < 500)
                    this.setIconBlack(); // Change to black if lighter color
                else
                    this.setIconWhite(); // Change to white if darker color
            },

            handleCloseDropdown() {
                // Slight delay to prevent immediate closing when clicking outside
                setTimeout(() => {
                    this.isColorPickerOpen = false;
                }, 200);
            }
        };
    }
    </script>
