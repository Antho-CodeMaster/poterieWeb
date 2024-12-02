<x-app-layout>
    <div>
        {{-- Modal de remerciement d'avoir envoyé une demande --}}
        @if (Session::has('succesDemande'))
            @include('components.devenir-artiste-succes-modal')
        @endif
        {{-- Modal de remerciement d'avoir envoyé une demande --}}
        @if (Session::has('succesRenouvellement'))
            <div class="w-[500px] fixed z-50 right-2 bottom-10">
                @include('messages.messageSucces', [
                    'message' => Session::get('succesRenouvellement'),
                    'titre' => 'Succès',
                ])
            </div>
        @endif
        {{-- Span qui, s'il existe, va trigger l'ouvertur du modal de connexion --}}
        @if (Session::has('openLoginModal'))
            <span id="showLoginModal" class="hidden"></span>
        @endif
        @if ($errors->any())
            <div class="w-[500px] fixed z-50 right-2 bottom-10">
                @include('messages.messageFail', [
                    'message' => $errors->first('msg'),
                    'titre' => 'Échec',
                ])
            </div>
        @endif
    </div>

    <!-- Parallax Section -->
    <div id="parallax-img" class="relative top-0 h-[101vh] w-full overflow-hidden">
        <div class="bg-cover bg-center min-h-full w-full" style="background-image: url('/../covers/cover_picture.png');">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-between items-center">
                <!-- Centered title -->
                <h1 class="text-beige text-8xl font-bold mt-auto">Artterre</h1>

                <div class="my-8 text-2xl text-center">
                    <ul class="flex justify-center space-x-4">
                        @foreach ($collections as $collection => $articles)
                            @if (!$articles->isEmpty())
                                <li class="relative inline-block overflow-hidden">
                                    <a href="#{{ $collection }}"
                                        class="p-4 text-beige hover:text-vert hover9 overflow-hidden relative inline-block transition-all duration-200 ease-out"
                                        data-hover-label="{{ $collection }}">
                                        <span
                                            class="hover9__label inline-block transition-transform duration-300 ease-[cubic-bezier(0.86, 0.6, 0.08, 1.01)]">
                                            {{ $collection }}
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <!-- Bottom-centered anchor link -->
                <a href="#collections" class="mb-[20%]">
                    <div class="arrow group">
                        <span class="group-hover:border-vert group-hover:ease-in-out group-hover:duration-300"></span>
                        <span class="group-hover:border-vert group-hover:ease-in-out group-hover:duration-300"></span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Les modals --}}
    @include('kiosque.modal.article-modal')

    <div id="collections">
        @if (
            !(
                $collections['En vedette']->isEmpty() &&
                $collections['Nouveautés']->isEmpty() &&
                $collections['Découvrez']->isEmpty() &&
                $collections['Vos articles aimés']->isEmpty()
            ))
            @foreach ($collections as $collection => $articles)
                @if (!$articles->isEmpty())
                    <div id="{{ $collection }}" class="pt-2">
                        <x-decouverte.collection-articles :collection="$articles" :collectionName="$collection" />
                    </div>
                @endif
            @endforeach
        @else
            <div class="flex flex-col h-screen">
                <span class="h-1/3"></span>

                <div class="flex flex-col items-center align-center m-4 p-4 rounded bg-darkGrey">
                    <div class="m-6 justify-center">
                        <h1 class="text-center text-3xl text-beige">Oups, nous semblons avoir rencontré un problème,
                            veuillez réessayer plus tard.</h1>
                    </div>

                    <div class="my-6 relative">
                        <div class="circle-border absolute z-0 w-16 h-16 rounded-[50%] bg-jauneWarning scale-110"></div>
                        <div class="circle relative z-1 w-16 h-16 rounded-[50%] bg-white scale-100">
                            <div class="x-icon"></div>
                        </div>
                    </div>
                </div>

                <span class="h-1/3"></span>
            </div>
        @endif
    </div>
</x-app-layout>
