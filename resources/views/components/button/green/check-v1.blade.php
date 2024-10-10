<x-button.green.base {{ $attributes }}>
    <svg class="h-6 w-6 my-auto" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 11.917L9.724 16.5L19 7.5" stroke="#C1EFD7" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>
    <x-slot name="p">{{ $slot }}</x-slot>
</x-button.green.base>
