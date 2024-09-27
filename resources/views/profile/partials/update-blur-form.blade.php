<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Accessibilité') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Flouter les images sensibles.") }}
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
            <div class="relative h-6 w-11 after:h-5 after:w-5 peer-checked:after:translate-x-5 rounded-full border border-darkGrey bg-darkGrey after:absolute after:bottom-0 after:left-[0.0625rem] after:top-0 after:my-auto after:rounded-full after:bg-darkGrey after:transition-all after:content-[''] peer-checked:bg-darkGrey peer-checked:after:bg-darkGray peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:border-darkGrey dark:bg-rouge dark:after:bg-beige dark:peer-checked:bg-vert dark:peer-checked:after:bg-beige" aria-hidden="true"></div>
        </label>

        @if (session('status') === 'blur-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600"
        >{{ __('Sauvegardé.') }}</p>
    @endif
    </form>
</section>
