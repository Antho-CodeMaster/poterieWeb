<x-button.green.base {{ $attributes }}>
    <svg class="my-auto" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 12L3 5L21 12L3 19L6 12ZM6 12L11 12" stroke="#C1EFD7" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>

    <x-slot name="p">{{ $slot }}</x-slot>
</x-button.green.base>
