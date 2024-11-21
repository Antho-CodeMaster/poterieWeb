<div class="w-full h-fit bg-beige border-2 border-l-8 border-rougeFail p-2 flex gap-1 items-center mt-2 animate-fadeOut">
    <svg class="w-11 h-11 text-gray-800 dark:text-white border-1px border-darkGrey" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
        height="24" fill="#f4f0ec" viewBox="0 0 24 24">
        <path stroke="#e60000" stroke-linecap="round" stroke-width="2"
            d="m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>

    <div class="w-[85%]">
        <div class="flex items-baseline">
            <p class="font-bold text-[26px]">{{ $titre }}</p>
        </div>

        <p class="text-[15px]">{{ $message }}</p>
    </div>
</div>
