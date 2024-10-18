<x-app-layout>
    <div>
        @if (Session::all())
            {{-- Modal de remerciement d'avoir envoyé une demande --}}
            @if (Session::has('succesDemande'))
                @include('components.devenir-artiste-succes-modal')
            @endif
            {{-- Span qui, s'il existe, va trigger l'ouvertur du modal de connexion --}}
            @if (Session::has('openLoginModal'))
                <span id="showLoginModal" class="hidden"></span>
            @endif
        @endif
    </div>

    <!-- Parallax Section -->
    <div id="parallax-img" class="relative top-0 h-screen w-full overflow-hidden">
        <div class="bg-cover bg-center h-full w-full"
             style="background-image: url('/../covers/cover_picture.png');">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <h1 class="text-beige text-5xl font-bold">@Terracium</h1>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('resize', () => {
            document.querySelectorAll('[x-data]').forEach(el => {
                const alpineComponent = el.__x.$data;
                alpineComponent.height = window.innerHeight;
            });
        });
    </script>


    <div>
        @foreach($collections as $collection)
            <x-collection-articles :collection="$collection" />
        @endforeach
    </div>
</x-app-layout>
