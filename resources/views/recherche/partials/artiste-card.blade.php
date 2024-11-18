<a class="flex shadow-md rounded-md border border-darkGrey p-4" href={{route('kiosque', ['idUser' => $artiste->id_user])}}>
    {{-- Photo de profil --}}
    <div class="flex-shrink-0 mx-auto">
        <img src="/../{{ $artiste->path_photo_profil }}" alt="photo de profil" class="w-[150px] h-[150px] rounded-[100px]">
    </div>
    <div class="w-3/4">
        {{-- Nom d'artiste --}}
        <div class="text-left titre3-dark m-titreY text-nowrap text-ellipsis">
            @if ($artiste->nom_artiste == null)
                {{ $artiste->user->name }}
            @else
                {{ $artiste->nom_artiste }}
            @endif
        </div>

        {{-- Description de l'artiste --}}
        <div class="text-left textPetit-dark text-wrap">
            <p>{{ $artiste->description }}</p>
        </div>
    </div>
</a>
