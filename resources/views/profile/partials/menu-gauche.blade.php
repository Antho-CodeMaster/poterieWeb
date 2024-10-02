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
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z"
                    clip-rule="evenodd" />
            </svg>

            <p class="text-2xl text-darkGrey">Facturation</p>
        </a>
    </div>
</div>
