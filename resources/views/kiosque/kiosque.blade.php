<x-app-layout>
    {{-- Section Bannière --}}
    <section class="flex items-center justify-between p-[16px]" {{-- style="background-color: #{{ $artiste->couleur_banniere }}" --}}>
        {{-- Nom d'artiste --}}
        <div class="flex-1 text-left reseaux">
            {{ $artiste->nom_artiste }}
        </div>

        {{-- Photo de profil --}}
        <div class="flex-shrink-0 mx-auto ">
            <img src="img/{{ $artiste->path_photo_profil }}" alt="photo de profil"
                class="w-[150px] h-[150px] rounded-[100px]">
        </div>

        {{-- Réseaux sociaux --}}
        <div class="flex-1 felx-shrink">
            @foreach ($reseaux as $reseau)
                <div class="text-right">
                    <a href="{{ $reseau->url }}{{ $reseau->pivot->username }}" class="inline-flex items-center">
                        <p class="reseaux">{{ $reseau->pivot->username }}</p>

                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'YouTube')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif
                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Instagram')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif
                        {{-- Si réseau youtube --}}
                        @if ($reseau->reseau == 'Facebook')
                            <svg class="w-10 h-10 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                    clip-rule="evenodd" class="text-darkGrey" />
                            </svg>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section En vedette --}}
    <section>
        <div class="bg-beige flex items-center">
            {{-- Flèche gauche --}}
            <svg class="w-16 h-16 text-darkGrey" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 19-7-7 7-7" />
            </svg>

            <div class="flex">
                {{-- Apparence de l'article selon l'état --}}
                @foreach ($articles as $article)
                    @if ($article->etat->etat == 'Visible client')
                        <div class="w-[300px] m-[16px] overflow-hidden whitespace-nowrap">
                            <img src="img/{{ $article->photosArticle->path }}" alt="Photo d'article"
                                class="shadow-md rounded-[16px] cursor-pointer">
                            <p class="article flex my-[8px] animate-scrollText" id="scrollingText">{{ $article->nom }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Flèche droite --}}
            <svg class="w-16 h-16 text-darkGrey" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m9 5 7 7-7 7" />
            </svg>
        </div>
    </section>
</x-app-layout>

{{-- TODO: La partie responsive --}}
