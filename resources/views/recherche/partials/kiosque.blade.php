<x-app-layout>
    {{-- Section Tous les articles --}}
    <section class="mt-[32px]">
        <div class="flex justify-between items-center">
            <div class="flex">
                <h2 class="titre2 ml-[16px] mr-[2px]">Tous les articles</h2>
                <svg class="w-8 h-8 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="#444444" viewBox="0 0 24 24">
                    <path
                        d="M10.83 5a3.001 3.001 0 0 0-5.66 0H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17ZM4 11h9.17a3.001 3.001 0 0 1 5.66 0H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2Zm1.17 6H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17a3.001 3.001 0 0 0-5.66 0Z" />
                </svg>
            </div>
        </div>
        <div class="bg-beige flex flex-wrap justify-between">

            {{-- Affichage de tous les articles --}}
            @if ($article->etat->etat == 'Visible client' || $article->etat->etat == 'Masqué client')
                @foreach ($articles as $article)

                @endforeach
            @endif
        </div>
    </section>
</x-app-layout>

{{-- TODO: La partie responsive --}}
