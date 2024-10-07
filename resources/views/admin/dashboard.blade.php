<x-app-layout>
    <div class="flex content-height">
        <!-- Menu de gauche -->
        @include('admin.menu-gauche')
        <!-- Contenu de la page -->
        <div class="pt-20 px-20 w-[90%] h-[100%] flex flex-col">
            <h1 class="text-4xl text-black">Tableau de bord</h1>
            <!-- Conteneur des statistiques -->
            <div class="flex flex-wrap grow justify-evenly py-4 overflow-auto mt-8">

                <a href="{{ route('admin-utilisateurs') }}" class="my-6 mx-4 min-w-[344px] w-[25%] min-h-[200px] h-[25%] border-2 border-black rounded-[14px] flex flex-col justify-around p-2 bg-lightGrey hover:bg-hoverGrey">
                    <svg class="w-16 h-16 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="black" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="mx-auto flex flex-col">
                        <p class="mx-auto text-2xl">{{$utilisateurs}}</p>
                        <p class="mx-auto text-2xl">Utilisateurs</p>
                    </div>
                </a>

                <a href="{{ route('admin-publications') }}" class="my-6 mx-4 min-w-[344px] w-[25%] min-h-[200px] h-[25%] border-2 border-black rounded-[14px] flex flex-col justify-around p-2 bg-lightGrey hover:bg-hoverGrey">
                    <svg class="w-16 h-16 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="black" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M5 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11.5c.07 0 .14-.007.207-.021.095.014.193.021.293.021h2a2 2 0 0 0 2-2V7a1 1 0 0 0-1-1h-1a1 1 0 1 0 0 2v11h-2V5a2 2 0 0 0-2-2H5Zm7 4a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h.5a1 1 0 1 1 0 2H13a1 1 0 0 1-1-1Zm-6 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1ZM7 6a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7Zm1 3V8h1v1H8Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="mx-auto flex flex-col">
                        <p class="mx-auto text-2xl">{{$articles}}</p>
                        <p class="mx-auto text-2xl">Publications</p>
                    </div>
                </a>

                <a href="{{ route('admin-signalements') }}" class="my-6 mx-4 min-w-[344px] w-[25%] min-h-[200px] h-[25%] border-2 border-black rounded-[14px] flex flex-col justify-around p-2 bg-lightGrey hover:bg-hoverGrey">
                    <svg class="w-16 h-16 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="black" stroke-linecap="round" stroke-width="2"
                            d="m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div class="mx-auto flex flex-col">
                        <p class="mx-auto text-2xl">{{$signalements}}</p>
                        <p class="mx-auto text-2xl">Signalements</p>
                    </div>
                </a>

                <a href="{{ route('admin-demandes') }}" class="my-6 mx-4 min-w-[344px] w-[25%] min-h-[200px] h-[25%] border-2 border-black rounded-[14px] flex flex-col justify-around p-2 bg-lightGrey hover:bg-hoverGrey">
                    <svg class="w-16 h-16 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="black" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="mx-auto flex flex-col">
                        <p class="mx-auto text-2xl">{{$demandes}}</p>
                        <p class="mx-auto text-2xl">Demandes d'inscription</p>
                    </div>
                </a>

                <a href="{{ route('admin-articles-non-recus') }}" class="my-6 mx-4 min-w-[344px] w-[25%] min-h-[200px] h-[25%] border-2 border-black rounded-[14px] flex flex-col justify-around p-2 bg-lightGrey hover:bg-hoverGrey">
                    <svg class="w-16 h-16 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="black" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="mx-auto flex flex-col">
                        <p class="mx-auto text-2xl">{{$articles_non_recus}}</p>
                        <p class="mx-auto text-2xl">Articles non reçus</p>
                    </div>
                </a>

                <a href="{{ route('admin-transactions') }}" class="my-6 mx-4 min-w-[344px] w-[25%] min-h-[200px] h-[25%] border-2 border-black rounded-[14px] flex flex-col justify-around p-2 bg-lightGrey hover:bg-hoverGrey">
                    <svg class="w-16 h-16 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="black" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="mx-auto flex flex-col">
                        <p class="mx-auto text-2xl">{{$transactions}}</p>
                        <p class="mx-auto text-2xl">Transactions</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
