<!-- Navigation Menu -->
<div class="w-[250px] bg-beige h-full">
    <!-- Boutons de droite -->
    <div class="items-center">

        {{-- Bouton Utilisateurs --}}
        <a href="{{ route('profile.edit') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() == 'profile/edit' ? 'bg-hoverGrey' : ''  }}">
            <svg class="mr-4 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                    clip-rule="evenodd" />
            </svg>
            <p class="text-2xl text-darkGrey">Profil</p>
        </a>

        {{-- Bouton Facturation --}}
        <a href="{{ route('profile.facturation') }}" class="p-4 flex hover:bg-hoverGrey items-center {{ Request::path() == 'profile/facturation' ? 'bg-hoverGrey' : ''  }}">

            <svg class="mr-4 w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.33335 9.16667C6.36089 9.16667 5.42826 9.55298 4.74063 10.2406C4.053 10.9282 3.66669 11.8609 3.66669 12.8333V31.1667C3.66669 32.1391 4.053 33.0718 4.74063 33.7594C5.42826 34.447 6.36089 34.8333 7.33335 34.8333H36.6667C37.6391 34.8333 38.5718 34.447 39.2594 33.7594C39.947 33.0718 40.3334 32.1391 40.3334 31.1667V12.8333C40.3334 11.8609 39.947 10.9282 39.2594 10.2406C38.5718 9.55298 37.6391 9.16667 36.6667 9.16667H7.33335ZM7.33335 20.1667H36.6667V31.1667H7.33335V20.1667Z"
                fill="#444444"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.16669 25.6667C9.16669 25.1804 9.35984 24.7141 9.70366 24.3703C10.0475 24.0265 10.5138 23.8333 11 23.8333H14.6667C15.1529 23.8333 15.6192 24.0265 15.963 24.3703C16.3069 24.7141 16.5 25.1804 16.5 25.6667C16.5 26.1529 16.3069 26.6192 15.963 26.963C15.6192 27.3068 15.1529 27.5 14.6667 27.5H11C10.5138 27.5 10.0475 27.3068 9.70366 26.963C9.35984 26.6192 9.16669 26.1529 9.16669 25.6667ZM18.3334 25.6667C18.3334 25.1804 18.5265 24.7141 18.8703 24.3703C19.2141 24.0265 19.6805 23.8333 20.1667 23.8333H29.3334C29.8196 23.8333 30.2859 24.0265 30.6297 24.3703C30.9735 24.7141 31.1667 25.1804 31.1667 25.6667C31.1667 26.1529 30.9735 26.6192 30.6297 26.963C30.2859 27.3068 29.8196 27.5 29.3334 27.5H20.1667C19.6805 27.5 19.2141 27.3068 18.8703 26.963C18.5265 26.6192 18.3334 26.1529 18.3334 25.6667Z"
                fill="#444444"/>
            </svg>


            <p class="text-2xl text-darkGrey">Facturation</p>
        </a>
    </div>
</div>