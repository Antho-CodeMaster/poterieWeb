<x-button.red.base {{ $attributes }}>
    <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="none" viewBox="0 0 24 24">
        <path stroke="#FFBEBE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
    </svg>
    <x-slot name="p">{{ $slot }}</x-slot>
</x-button.red.base>
