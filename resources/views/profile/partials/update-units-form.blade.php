<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Unités') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Changer l'unité de mesure.") }}
        </p>
    </header>

    <form method="post" action="{{ route('updateUnits') }}" class="mt-6 space-y-6 rounded-md" id="unitsForm">
        @csrf
        <select name="units" id="units" class="rounded-md" onchange="document.getElementById('unitsForm').submit()">
            <option value="0" {{ Auth::user()->units == 0 ? 'selected' : '' }}>
                Centimètres
            </option>
            <option value="1" {{ Auth::user()->units == 1 ? 'selected' : '' }}>
                Pouces
            </option>
        </select>
    </form>
</section>
