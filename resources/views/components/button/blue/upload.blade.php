<x-button.blue.base {{ $attributes }}>
    <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
        height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="#3779A9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
    </svg>
    <x-slot name="p">{{ $slot }}</x-slot>
</x-button.blue.base>
