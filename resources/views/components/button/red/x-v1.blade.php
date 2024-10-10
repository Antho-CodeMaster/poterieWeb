<x-button.red.base {{ $attributes }}>
    <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="none" viewBox="0 0 24 24">
        <path stroke="#FFBEBE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 18 17.94 6M18 18 6.06 6" />
    </svg>
    <x-slot name="p">{{ $slot }}</x-slot>
</x-button.red.base>
