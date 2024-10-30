<div class="w-full h-fit bg-beige border-2 border-l-8 border-jauneWarning p-2 flex gap-1 items-center mt-2">
    <svg class="w-11 h-11 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
        height="24" fill='#E6AF00' viewBox="0 0 24 24">
        <path fill-rule="evenodd"
            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
            clip-rule="evenodd" />
    </svg>

    <div class="w-[85%]">
        <div class="flex items-baseline">
            <p class="font-bold text-[26px]">{{ $titre }}</p>
        </div>

        <p class="text-[15px]">{{ $message }}</p>
    </div>
</div>
