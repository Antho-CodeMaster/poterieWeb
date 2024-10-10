<x-button.blue.base {{ $attributes }}>
    <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="none" viewBox="0 0 24 24">
        <path stroke="#3779A9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
    </svg>
    <x-slot name="p">{{ $slot }}</x-slot>
</x-button.blue.base>
