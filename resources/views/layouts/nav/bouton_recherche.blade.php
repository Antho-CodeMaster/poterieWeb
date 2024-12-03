{{-- Icône recherche pour format mobile --}}
<span class="relative group">
    <a class="lg:hidden block mr-6" href="{{ route('recherche.getSearch') }}">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="34" height="34"
            fill="none" viewBox="0 0 24 24">
            <path stroke="#444444" stroke-linecap="round" stroke-width="2"
                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
        </svg>
    </a>
    <!-- Tooltip content -->
    <div
        class="absolute bg-hoverBeige text-md rounded-md p-2 shadow-lg w-fit
                    invisible opacity-0 group-hover:visible group-hover:opacity-100 transition duration-200 ease-in-out
                    translate-y-2 top-full left-1/2 transform -translate-x-1/2">
        Rechercher
    </div>
</span>
