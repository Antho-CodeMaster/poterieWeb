<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Accessibilité') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Certaines images sur le site peuvent être considérées sensibles. ") }}
        </p>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Activer ce bouton permet de flouter les images des publications que les artistes ont identifiées comme sensibles.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateBlur') }}" class="mt-6 space-y-6" id="toggleForm">
        @csrf

        <input type="hidden" name="blurValue" value="1">

        <label for="defaultToggle" class="inline-flex cursor-pointer items-center">
            <input
                id="defaultToggle"
                name="blurValue"
                type="checkbox"
                class="peer sr-only"
                role="switch"
                {{ ($user->contenu_sensible === 1 ? 'unchecked' : 'checked') }}
                onchange="document.getElementById('toggleForm').submit()"
            />
            <div class="relative h-6 w-11 after:h-5 after:w-5 peer-checked:after:translate-x-5 rounded-full border border-darkGrey bg-darkGrey after:absolute after:bottom-0 after:left-[0.0625rem] after:top-0 after:my-auto after:rounded-full after:bg-darkGrey after:transition-all after:content-[''] peer-checked:bg-darkGrey peer-checked:after:bg-darkGray peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:border-darkGrey dark:bg-rouge hover:dark:bg-red-500  dark:after:bg-beige dark:peer-checked:bg-vert hover:dark:peer-checked:bg-lightVert dark:peer-checked:after:bg-beige" aria-hidden="true"></div>
        </label>
    </form>
</section>
