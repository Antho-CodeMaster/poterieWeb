<section class="flex items-center justify-between p-[16px] bg-{{ $artiste->couleur_banniere }}">

    <div class="dynamicText flex-1" data-background-color="{{ $artiste->couleur_banniere }}">
        {{-- Nom d'artiste --}}
        <div class="text-left lg:titre1-dark m-titreY md:titre2-dark titre3-dark">
            @if ($artiste->nom_artiste == null)
                {{ $artiste->user->name }}
            @else
                {{ $artiste->nom_artiste }}
            @endif
        </div>

        {{-- Déscription de l'artiste --}}
        <div class=" text-left textGrand-dark">
            {{ $artiste->description }}
        </div>
    </div>

    {{-- Photo de profil --}}
    <div class="flex-shrink-0 mx-auto ">
        <img src="/../{{ $artiste->path_photo_profil }}" alt="photo de profil"
            class="w-[150px] h-[150px] rounded-[100px]">
    </div>

    {{-- Réseaux sociaux --}}
    <div class="dynamicText flex-1 felx-shrink">
        @foreach ($reseaux as $reseau)
            <div class="text-right">
                <a href="{{ $reseau->url }}{{ $reseau->pivot->username }}" class="inline-flex items-center">
                    <p class="articleGrand-dark">{{ $reseau->pivot->username }}</p>

                    {{-- Si réseau youtube --}}
                    @if ($reseau->reseau == 'YouTube')
                        <svg class="w-10 h-10 dynamicText" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                clip-rule="evenodd" class="dynamicText"/>
                        </svg>
                    @endif

                    {{-- Si réseau youtube --}}
                    @if ($reseau->reseau == 'Instagram')
                        <svg class="w-10 h-10 dynamicText" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                clip-rule="evenodd" class="dynamicText" />
                        </svg>
                    @endif

                    {{-- Si réseau youtube --}}
                    @if ($reseau->reseau == 'Facebook')
                        <svg class="w-10 h-10 dynamicText" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                clip-rule="evenodd" class="dynamicText" />
                        </svg>
                    @endif
                </a>
            </div>
        @endforeach
    </div>
</section>
