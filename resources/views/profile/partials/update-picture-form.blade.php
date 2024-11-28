<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Photo de profil") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettre à jour votre photo d'artiste.") }}
        </p>
    </header>

    <!-- Form for uploading image -->
    <form action="{{ route('artiste.updatePicture') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div x-data="{ isHovered: false, clickInput() { $refs.imageInput.click() } }" class="relative h-fit w-fit">
            <div class="my-4"
                @mouseenter="isHovered = true"
                @mouseleave="isHovered = false"
            >
                <img @click="clickInput" id="image-preview" src="{{ asset($artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}" alt="Photo de profil"
                    :class="isHovered ? 'border-2 border-vert scale-105' : ''"
                    class="transition-transform duration-300 rounded-full w-32 h-32"
                >

                <!-- File input for selecting an image -->
                <input x-ref="imageInput" class="absolute w-full bottom-0 opacity-0 pointer-events-none"
                id="image-input" type="file" name="image" accept=".png, .jpg, .jpeg" onchange="previewImage(event)"
                >

                <svg @click="clickInput"
                :class="isHovered ? 'stroke-vert scale-105' : ''"
                class="absolute right-1 bottom-1 fill-beige transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#444444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <g transform="translate(2 3)">
                        <path d="M20 16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3l2-3h6l2 3h3a2 2 0 0 1 2 2v11z"/>
                        <circle cx="10" cy="10" r="4"/>
                    </g>
                </svg>
            </div>
        </div>

        <input type="submit" hidden value="Upload">

        <div class="flex items-center gap-4 mt-2">
            <x-primary-button class="hover:bg-lightVert bg-vert">{{ __('Sauvegarder') }}</x-primary-button>

            @if (session('status') === 'picture-updated')
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
