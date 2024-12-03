{{-- Bouton panier --}}
<span class="relative group -translate-y-3">
    <a class="ml-[15px] relative" href="{{ route('panier') }}">
        <p id="basketCount"
            class="mx-auto bg-red-500 text-white text-sm text-center rounded w-fit absolute -right-2 top-4 {{ $basketCount > 9 ? 'px-1' : 'px-1.5' }} {{$basketCount > 0 ? '' : 'invisible'}}">
            {{ $basketCount }}</p>
        <svg width="34" height="34" viewBox="0 0 48 48" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2 2H10L15.36 28.78C15.5429 29.7008 16.0438 30.5279 16.7751 31.1166C17.5064 31.7053 18.4214 32.018 19.36 32H38.8C39.7386 32.018 40.6536 31.7053 41.3849 31.1166C42.1162 30.5279 42.6171 29.7008 42.8 28.78L46 12H12M20 42C20 43.1046 19.1046 44 18 44C16.8954 44 16 43.1046 16 42C16 40.8954 16.8954 40 18 40C19.1046 40 20 40.8954 20 42ZM42 42C42 43.1046 41.1046 44 40 44C38.8954 44 38 43.1046 38 42C38 40.8954 38.8954 40 40 40C41.1046 40 42 40.8954 42 42Z"
                stroke="#444444" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
    <!-- Tooltip content -->
    <div
        class="absolute bg-hoverBeige text-md rounded-md p-2 shadow-lg w-fit
        invisible opacity-0 group-hover:visible group-hover:opacity-100 transition duration-200 ease-in-out
        translate-y-2 top-full left-1/2 transform -translate-x-1/2">
        Panier
    </div>
</span>
