<section>
    <!-- The image preview -->
    <img id="image-preview" src="{{ asset($artiste->path_photo_profil ?? 'img/artistePFP/default_artiste.png') }}" alt="Profile Picture" class="rounded-full my-4" style="max-width: 200px; max-height: 200px;">

    <!-- Form for uploading image -->
    <form action="{{ route('artiste.updatePicture') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- File input for selecting an image -->
        <input id="image-input" type="file" name="image" accept=".png, .jpg, .jpeg" onchange="previewImage(event)">
        <input type="submit" hidden value="Upload">

        <div class="flex items-center gap-4 my-4">
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
